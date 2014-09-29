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
		if ( Input::has('limit') ) {
			$limit   = Input::get('limit');
			$offset  = Input::get('offset', 0);
			$records = ApplyRecord::skip($offset)->take($limit )->orderBy('created_at', 'desc')->get();
		}
		else {
			$records = ApplyRecord::orderBy('created_at', 'desc')->get();
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

		if ( $board->isUsing( $from, $end ) ) {
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
