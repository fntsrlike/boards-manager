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
			return Response::json(['success' => true]);
		}

		return Response::json(['success' => false, 'messages' => 'Username and password dismatch.']);

	}

	public function logout()
	{
		Auth::logout();
		$is_json  = Input::get('method') == 'json';
		return $is_json ? Response::json(['success' => true]) : Redirect::to('/');
	}

	public function info()
	{

		if (Auth::check()) {
			$info = [
				'id'        => Auth::id(),
				'username'  => Auth::user()->username,
				'email'     => Auth::user()->email,
				'type'      => Auth::user()->type,
			];

			return Response::json(['success' => true, 'info' => $info]);
		}

		return Response::json(['success' => false]);

	}

}
