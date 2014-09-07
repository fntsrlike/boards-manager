<?php

class ApplyRecordController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$records = ApplyRecord::all();
		return Response::json($records);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		ApplyRecord::create(array(
			'board_id' 		=> Input::get('board_id'),
			'user_id' 		=> Input::get('user_id'),
			'event_name' 	=> Input::get('event_name'),
			'event_type'	=> Input::get('event_type'),
			'post_from' 	=> Input::get('post_from'),
			'post_end' 		=> Input::get('post_end'),
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
		$records = ApplyRecord::find($id);
		return Response::json($records);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		ApplyRecord::find($id)->update(array(
			'board_id' 		=> Input::get('board_id'),
			'user_id' 		=> Input::get('user_id'),
			'event_name' 	=> Input::get('event_name'),
			'event_type'	=> Input::get('event_type'),
			'post_from' 	=> Input::get('post_from'),
			'post_end' 		=> Input::get('post_end'),
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
		ApplyRecord::destroy($id);
		return Response::json(array('success' => true));
	}


}
