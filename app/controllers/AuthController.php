<?php

class AuthController extends BaseController {

	public function login()
	{
		$username = Input::get('username');
		$password = Input::get('password');
		$is_json  = Input::get('method') == 'json';

		$user = User::where('username', '=', $username)
					->where('password', '=', $password)
					->first();

		if ($user != null)
		{
			Auth::loginUsingId($user->id);
		    return Response::json(array('success' => true));
		}

		return Response::json(array('success' => false));

	}

	public function logout()
	{
		Auth::logout();
		$is_json  = Input::get('method') == 'json';
		return $is_json ? Response::json(array('success' => true)) : Redirect::to('/');
	}

	public function register()
	{
		$validator = Validator::make( Input::all(), array(
			'username'	=> 'required|between:3,24|unique:users,username',
			'password' 	=> 'required|between:8,32',
			'password2'	=> 'required|same:password',
			'title' 	=> 'required|between:3,24',
			'email' 	=> 'required|email',
			'phone' 	=> 'required|min:5',
		));

		if ($validator->fails()) {
			return Response::json(array('success' => false));
		}
		else {			
			$user = User::create(array(
				'username' 		=> Input::get('username'),
				'password' 		=> Input::get('password'),
				'title' 		=> Input::get('title'),
				'roles' 		=> 'normal',
				'email' 		=> Input::get('email'),
				'phone' 		=> Input::get('phone'),
			));

			Auth::loginUsingId($user->id);

			return Response::json(array('success' => true));
		}

	}

	public function info()
	{

		if (Auth::check()) {
		    $info['id'] = Auth::id();
		    $info['username'] = Auth::user()->username;
		    $info['email'] = Auth::user()->email;
		    $info['type'] = Auth::user()->type;

		    return Response::json(array('success' => true, 'info' => $info));
		}

		return Response::json(array('success' => false));

	}

}
