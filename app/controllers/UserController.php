<?php

class UserController extends \BaseController {

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
		if ( !Auth::user()->can('users_management') ){
			throw new Exception("Permission Deny", 1);
		}

		// TODO: Form Validation

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
		if ( !( Auth::user()->can('users_management') OR ($id !== Auth::id()) ) ){
			throw new Exception("Permission Deny", 1);
		}

		// TODO: Form Validation

		$update_info = array(
			'password' 		=> Input::get('password'),
			'title' 		=> Input::get('title'),
			'email' 		=> Input::get('email'),
			'phone' 		=> Input::get('phone'),
		);

		if ( Auth::user()->can('users_management') ) {
			$update_info = array_merge($update_info, [
				'username' 		=> Input::get('username'),
				'phone' 		=> Input::get('phone'),
			]);
		}

		// Clear empty elements
		$update_info = array_diff($update_info, ['']);

		User::find($id)->update($update_info);

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
		if ( !( Auth::user()->can('users_management') OR ($id !== Auth::id()) ) ){
			throw new Exception("Permission Deny", 1);
		}

		$user = User::destroy($id);
        return Response::json(array('success' => true));
	}

}
