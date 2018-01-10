<?php

namespace App\models\database;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract 
{
	use Authenticatable, CanResetPassword;
	protected $table = 'user';
	protected $fillable = ['username', 'password'];
    public $timestamps = false;
    
    public function site()
    {
        return $this->hasOne('App\models\database\UserSite', 'id_user', 'id');
    }
}
