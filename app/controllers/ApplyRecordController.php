<?php

class ApplyRecordController extends \BaseController {

	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		$CUD = array('only' => ['store', 'update', 'destroy']);
		$UD  = array('only' => ['update', 'destroy']);
		$R   = array('only' => ['index','show']);

		$this->beforeFilter('auth', $CUD);
		$this->beforeFilter('perm_apply', $CUD);
		$this->beforeFilter('perm_apply_owner', $UD);
		$this->beforeFilter('input_date', $R);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$records = ApplyRecord::orderBy('created_at', 'desc')->orderBy('id', 'desc');

		if ( Input::has('fields') ) {
			$fields  = explode(',', Input::get('fields'));
			$records = $records->select($fields);
		}

		if ( Input::has('list') ) {
			$list    = explode(',', Input::get('list'));
			$records = $records->whereIn('id', $list);
		}

		if ( Input::has('user_list') ) {
			$list    = explode(',', Input::get('user_list'));
			$records = $records->whereIn('user_id', $list);
		}

		if ( Input::has('board_list') ) {
			$list    = explode(',', Input::get('board_list'));

			foreach ($list as $key => $value) {
				if ( !is_numeric($value) ) {
					$board = Board::where('code', $value)->first();
					if ( $board != null) {
						$list[$key] = $board->id;
					}
					else {
						unset($list[$key]);
					}
				}
			}

			$records = $records->whereIn('board_id', $list);
		}

		if ( Input::has('type_list') ) {
			$list    = explode(',', Input::get('type_list'));
			var_dump($list);
			$records = $records->whereIn('event_type', $list);
		}

		if ( Input::has('from') or Input::has('end') ) {
			$from = Input::get('from', date('Y-m-d'));
			$end  = Input::get('end', date('Y-m-d'));
			$records = $records->where(function($records) use ($from, $end) {
				$records
				->orWhereRaw("('$from' between `post_from` AND `post_end`)")
				->orWhereRaw("('$end'  between `post_from` AND `post_end`)")
				->orWhereRaw("'$from' <= `post_from` AND `post_end` <= '$end'");
			});
		}

		if ( Input::has('date_list') ) {
			$list    = explode(',', Input::get('date_list'));
			$records = $records->where(function($records) use ($list) {
				foreach ($list as $date) {
					if ( strtotime($date) ) {
						$date = date('Y-m-d', strtotime($date));
						$records = $records->orWhereRaw("('$date' between `post_from` AND `post_end`)");
					}
				}
			});
		}

		if ( Input::has('limit') ) {
			$limit   = Input::get('limit');
			$offset  = Input::get('offset', 0);
			$records = $records->skip($offset)->take($limit )->get();
		}
		else {
			$records = $records->get();
		}

		return Response::json($records);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		# Config
		$config       = Config::get('poster');
		$post_types   = $config['post_types'];
		$event_types  = $config['event_types'];
		$days         = $config['days'];

		# Form Validation
		$rules = array(
			'code'     => 'required|exists:boards,code',
			'program'  => 'required|between:3,32',
			'type'     => 'required|in:' . implode(',', $event_types),
			'from'     => 'required|date_format:Y-m-d',
			'end'      => 'required|date_format:Y-m-d',
		);

		if ( Validator::make($rules)->fails() ) {
			return Response::json(['success' => false, 'errors' => $validator->errors()]);
		}

		# Poster Status Validation
		$board = Board::where('code', Input::get('code'))->first();
		$from  = Input::get('from');
		$end   = Input::get('end');
		$days_diff = round((strtotime($end) - strtotime($from))/60/60/24);

		if ( $board->getUsingStatus( $from, $end ) ) {
			return Response::json(['success' => false]);
		}

		# Days Validation
		if ( $board->type == 'large' and $days_diff >  $days['large_poster'] ) {
			return Response::json(['success' => false]);
		}

		if ( $days_diff > $days[Input::get('type')] ) {
			return Response::json(['success' => false]);
		}

		# Create
		ApplyRecord::create([
			'board_id'      => $board->id,
			'user_id'       => Auth::id(),
			'event_name'    => Input::get('program'),
			'event_type'    => Input::get('type'),
			'post_from'     => $from,
			'post_end'      => $end,
		]);

		return Response::json(['success' => true]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$apply_record = ApplyRecord::find($id);
		return Response::json($apply_record);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		# Form Validaiton
		$rules = array(
			'program'  => 'required|between:3,32',
		);

		if ( Validator::make($rules)->fails() ) {
			return Response::json(['success' => false, 'errors' => $validator->errors()]);
		}

		# Update
		$update = ['event_name' => Input::get('program')];
		ApplyRecord::find($id)->update($update);

		return Response::json(['success' => true]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		ApplyRecord::destroy($id);
		return Response::json(['success' => true]);
	}


}
