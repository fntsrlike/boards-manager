<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();
		return Response::json($users);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		User::create(array(
			'username' 		=> Input::get('username'),
			'password' 		=> Input::get('password'),
			'title' 		=> Input::get('title'),
			'roles' 		=> Input::get('roles'),
			'email' 		=> Input::get('email'),
			'phone' 		=> Input::get('phone'),
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
		$user = User::find($id);
		return Response::json($user);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		User::find($id)->updatte(array(
			'username' 		=> Input::get('username'),
			'password' 		=> Input::get('password'),
			'title' 		=> Input::get('title'),
			'roles' 		=> Input::get('roles'),
			'email' 		=> Input::get('email'),
			'phone' 		=> Input::get('phone'),
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
		$user = User::destroy($id);
        return Response::json(array('success' => true));
	}


}
