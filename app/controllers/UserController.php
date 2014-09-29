<?php

class UserController extends \BaseController {

	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		$CUD = array('only' => ['store', 'update', 'destroy']);

		$this->beforeFilter('auth', $CUD);
		$this->beforeFilter('perm_user_manage', $CUD);
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
			$users  = User::skip($offset)->take($limit )->orderBy('created_at', 'desc')->get();
		}
		else {
			$users = User::orderBy('created_at', 'desc')->get();
		}

		return Response::json($users);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		# Config
		$roles = array_keys(Config::get('role_perm.roles'));

		$validator = Validator::make(Input::all(), [
			'username'  => 'required|between:3,24|unique:users,username',
			'password'  => 'required|between:8,32',
			'password2' => 'required|same:password',
			'roles'     => 'required|in:' . implode(',', $roles),
			'title'     => 'required|between:3,24',
			'email'     => 'required|email|unique:users,email',
			'phone'     => 'required|min:5|unique:users,phone',
		]);

		if ($validator->fails()) {
			return Response::json(['success' => false]);
		}

		$user = User::create([
			'username'   => Input::get('username'),
			'password'   => Input::get('password'),
			'title'      => Input::get('title'),
			'roles'      => Input::get('roles'),
			'email'      => Input::get('email'),
			'phone'      => Input::get('phone'),
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
		# Config
		$roles = array_keys(Config::get('role_perm.roles'));

		$validator = Validator::make(Input::all(), [
			'username'  => 'sometimes|between:3,24|unique:users,username',
			'password'  => 'sometimes|between:8,32',
			'password2' => 'sometimes|same:password',
			'roles'     => 'sometimes|in:' . implode(',', $roles),
			'title'     => 'sometimes|between:3,24',
			'email'     => 'sometimes|email|unique:users,email',
			'phone'     => 'sometimes|min:5|unique:users,phone',
		]);

		if ($validator->fails()) {
			return Response::json(['success' => false]);
		}

		$update_info = array_diff([
			'username'   => Input::get('username'),
			'password'   => Input::get('password'),
			'roles'      => Input::get('roles'),
			'title'      => Input::get('title'),
			'email'      => Input::get('email'),
			'phone'      => Input::get('phone'),
		], ['']);

		User::find($id)->update($update_info);

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
		$user = User::destroy($id);
		return Response::json(['success' => true]);
	}

}
