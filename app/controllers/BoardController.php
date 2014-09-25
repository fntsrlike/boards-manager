<?php

class BoardController extends \BaseController {

	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		$this->beforeFilter('auth', ['only' => ['store', 'update', 'destroy']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$boards = Board::all();
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
		if ( !Auth::user()->can('boards_management') ){
			throw new Exception("Permission Deny", 1);
		}

		Board::create(array(
			'type' => Input::get('type'),
			'code' => Input::get('code'),
			'description' => Input::get('description'),
		));

		return Response::json(array('success' => true));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$board = Board::find($id);
		$isUsing = $board->isUsing( Input::get('from'), Input::get('end') );
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
		if ( !Auth::user()->can('boards_management') ){
			throw new Exception("Permission Deny", 1);
		}

		$board = Board::find($id)->update(array(
			'type' => Input::get('type'),
			'code' => Input::get('code'),
			'description' => Input::get('description'),
		));

		// Clear empty elements
		$update_info = array_diff($update_info, ['']);

		return Response::json(array('success' => true));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ( !Auth::user()->can('boards_management') ){
			throw new Exception("Permission Deny", 1);
		}

		Board::destroy($id);
		return Response::json(array('success' => true));
	}


}
