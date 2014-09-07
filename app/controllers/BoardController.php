<?php

class BoardController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$boards = Board::all();
		return Response::json($boards);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
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
		return Response::json($board);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$board = Board::find($id)->update(array(
			'type' => Input::get('type'),
			'code' => Input::get('code'),
			'description' => Input::get('description'),
		));

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
		Board::destroy($id);
		return Response::json(array('success' => true));
	}


}
