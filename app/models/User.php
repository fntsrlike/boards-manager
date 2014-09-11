<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token', 'email');
	protected $fillable = array('username', 'password', 'title', 'roles', 'email', 'phone');

	public function attachRole($role) {
		$origin = explode(',', $this->roles);
		$origin[] = $role;
		$this->roles = implode(',', $origin);
		$this->save();
	}

	public function attachRoles($roles) {
		$origin = explode(',', $this->roles);
		$origin = array_merge($origin, $roles);
		$this->roles = implode(',', $origin);
		$this->save();
	}

	public function detachRole($role) {
		$origin = explode(',', $this->roles);
		$origin = array_diff($origin, array($role));
		$this->roles = implode(',', $origin);
		$this->save();
	}

	public function detachRoles(Array $roles) {
		$origin = explode(',', $this->roles);
		$origin = array_diff($origin, $roles);
		$this->roles = implode(',', $origin);
		$this->save();
	}

	public function getRoles() {
		$roles = explode(',', $this->roles);
		return is_array($roles) ? $roles : [$roles];
	}

	public function hasRole($role) {
		return in_array($role, $this->getRoles());
	}

	public function can($permission) {
		$permission_role = Config::get('role_perm.permission_role');

		foreach ($this->getRoles() as $role) {
			if ( in_array($permission, $permission_role[$role]) ) {
				return true;
			}
		}

		return false;
	}

	public function ability(Array $roles, Array $permissions, $options = array() ) {
		if ( !( isset($options['validate_all']) and is_bool($options['validate_all']) ) ) {
			$options['validate_all'] = false;
		}

		if ( !( isset($options['return_type']) and
			    in_array($options['return_type'], ['boolean', 'array', 'both']) ) ) {
			$options['return_type'] = 'boolean';
		}

		foreach ($roles as $role) {
			$validations[$role] = $this->hasRole($role);
		}

		foreach ($permissions as $permission) {
			$validations[$permission] = $this->can($permission);
		}

		$is_pass = ($options['validate_all'] == true) ? !in_array(false, $validations) : in_array(true, $validations);

		switch ($options['return_type']) {
			case 'boolean':
			default:
				return $is_pass;
				break;

			case 'array':
				return $validations;
				break;

			case 'both':
				return [$is_pass, $validations];
				break;
		}
	}


}
