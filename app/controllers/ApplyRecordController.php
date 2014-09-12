<?php

class ApplyRecordController extends \BaseController {

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
		// TODO: Dynamic Loading by query string

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
		if ( !( Auth::user()->ability([], ['apply_records_management', 'apply_post']) ) ){
			throw new Exception("Permission Deny", 1);
		}

		// TODO: Form Validation
		// TODO: Poster Validation (ex. date can't repeat)

		ApplyRecord::create(array(
			'board_id' 		=> Input::get('board_id'),
			'user_id' 		=> Auth::id(),
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

		if ( !Auth::user()->can('apply_records_management')) {
			if ( !(Auth::user()->can('apply_post') AND (Board::find($id)->user_id !== Auth::id()) ) ){
				throw new Exception("Permission Deny", 1);
			}
		}

		// TODO: Form Validation
		// TODO: Poster Validation (ex. date can't repeat)

		$update_info = array(
			'event_name' 	=> Input::get('event_name'),
			'event_type'	=> Input::get('event_type'),
		);

		if ( Auth::user()->can('apply_records_management') ) {
			$update_info = array_merge($update_info, [
				'board_id' 		=> Input::get('board_id'),
				'user_id' 		=> Input::get('user_id'),
				'post_from' 	=> Input::get('post_from'),
				'post_end' 		=> Input::get('post_end'),
			]);
		}

		// Clear empty elements
		$update_info = array_diff($update_info, ['']);

		ApplyRecord::find($id)->update($update_info);

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
		if ( !Auth::user()->can('apply_records_management')) {
			if ( !( Auth::user()->can('apply_post') AND ApplyRecord::find($id)->isApplicant(Auth::id()) ) ){
				throw new Exception("Permission Deny", 1);
			}
		}

		ApplyRecord::destroy($id);
		return Response::json(array('success' => true));
	}


}
