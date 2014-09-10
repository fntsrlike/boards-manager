<?php

class AuthController extends BaseController {

	public function login()
	{
		$username = Input::get('username');
		$password = Input::get('password');

		if (Auth::attempt(array('username' => $username, 'password' => $password)))
		{
		    return Response::json(array('success' => true));
		}

		return Response::json(array('success' => false));

	}

	public function logout()
	{
		Auth::logout();
		return Response::json(array('success' => true));
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
