<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface
{
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
    protected $hidden   = ['password', 'remember_token', 'email'];
    protected $fillable = ['username', 'password', 'title', 'roles', 'email',
                           'phone'];

    const PERM_ROLE = 'role_perm.permission_role';

    public function attachRole($role)
    {
        $origin = explode(',', $this->roles);
        $origin[] = $role;
        $this->roles = implode(',', $origin);
        $this->save();
    }

    public function attachRoles($roles)
    {
        $origin = explode(',', $this->roles);
        $origin = array_merge($origin, $roles);
        $this->roles = implode(',', $origin);
        $this->save();
    }

    public function detachRole($role)
    {
        $origin = explode(',', $this->roles);
        $origin = array_diff($origin, [$role]);
        $this->roles = implode(',', $origin);
        $this->save();
    }

    public function detachRoles($roles)
    {
        $origin = explode(',', $this->roles);
        $origin = array_diff($origin, $roles);
        $this->roles = implode(',', $origin);
        $this->save();
    }

    public function getRoles()
    {
        $roles = explode(',', $this->roles);
        return is_array($roles) ? $roles : [$roles];
    }

    public function hasRole($role)
    {
        return in_array($role, $this->getRoles());
    }

    public function can($permission)
    {
        $permission_role = Config::get(self::PERM_ROLE);

        foreach ($this->getRoles() as $role) {
            if (in_array($permission, $permission_role[$role])) {
                return true;
            }
        }

        return false;
    }

    public function ability(Array $roles, Array $permissions, $options = [])
    {
        if (!isset($options['validate_all'])) {
            $options['validate_all'] = false;
        }

        if (!is_bool($options['validate_all'])) {
            $options['validate_all'] = false;
        }

        if (!isset($options['return_type'])) {
            $options['return_type'] = 'boolean';
        }

        $types = ['boolean', 'array', 'both'];
        if (!in_array($options['return_type'], $types)) {
            $options['return_type'] = 'boolean';
        }

        foreach ($roles as $role) {
            $validations[$role] = $this->hasRole($role);
        }

        foreach ($permissions as $permission) {
            $validations[$permission] = $this->can($permission);
        }

        if ($options['validate_all'] == true) {
            $is_pass = !in_array(false, $validations);
        } else {
            $is_pass = in_array(true, $validations);
        }

        switch ($options['return_type']) {
            case 'both':
                return [$is_pass, $validations];
                break;

            case 'array':
                return $validations;
                break;

            case 'boolean':
            default:
                return $is_pass;
                break;

        }
    }
}
