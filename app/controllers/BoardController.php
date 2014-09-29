<?php

class BoardController extends \BaseController {

	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		$R   = array('only' => ['index','show']);
		$CU  = array('only' => ['store', 'update']);
		$CUD = array('only' => ['store', 'update', 'destroy']);

		$this->beforeFilter('auth', $CUD);
		$this->beforeFilter('perm_boards_manage', $CUD);
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
			$limit  = Input::get('limit');
			$offset = Input::get('offset', 0);
			$boards = Board::skip($offset)->take($limit )->orderBy('created_at', 'desc')->get();
		}
		else {
			$boards = Board::orderBy('created_at', 'desc')->get();
		}

		$response = [];

		foreach ($boards as $board) {
			$isUsing = $board->isUsing( Input::get('from'), Input::get('end') );
			$response[] = array_merge($board->toArray(), ['isUsing' => $isUsing ] );
		}

		return Response::json($response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$types = Config::get('poster.board_types');

		$rules = array(
			'code' => 'required|alpha_dash',
			'type' => 'required|in:' . implode(',', $types),
		);

		if ( Validator::make($rules)->fails() ) {
			return Response::json(['success' => false, 'errors' => $validator->errors()]);
		}

		Board::create([
			'type' => Input::get('type'),
			'code' => Input::get('code'),
			'description' => Input::get('description'),
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
		$board    = intval($id)>0 ? Board::find($id) : Board::code($id);
		$isUsing  = $board->isUsing( Input::get('from'), Input::get('end') );
		$response = array_merge($board->toArray(), ['isUsing' => $isUsing ] );

		return Response::json($response);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$board = Board::find($id)->update([
			'description' => Input::get('description'),
		]);

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
		Board::destroy($id);
		return Response::json(['success' => true]);
	}

}
