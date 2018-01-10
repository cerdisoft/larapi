<?php

namespace App\models\database;

use Illuminate\Database\Eloquent\Model;

class UserSite extends Model
{
    protected $table = 'user_site';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\models\database\User', 'id_user', 'id');
    }
}
