<?php

namespace App\common\transactions;

use App\models\database\User;
use App\models\database\UserSite;
use App\models\database\UserSitePreferences;

use App\common\misc\Errors;


class UserTransaction
{
    private static $roles;
    private static $url_recover;


    private static function validateIfExistSite($id_site)
    {
        $site = UserSitePreferences::where('id_site', $id_site)->first();
        if ($site == null) {
            throw new \Exception(Errors::SITE_NOT_FOUND);
        }
        self::$roles = $site->roles; 
        self::$url_recover = $site->url_recover_password;
    }

    private static function validateExistRol($role)
    {
        $rolesUsuario = json_decode(self::$roles, true);
        if (is_bool(array_search($role, $rolesUsuario['roles'])) === true) {
            throw new \Exception(Errors::ROLE_NOT_REGISTERED);
        }
    }

    /*******************************************************/
    /*Guardamos la informacion del usuario y el perfil*/
    /*******************************************************/
    public static function createUser(
        $username,
        $password,
        $email,
        $role,
        $id_site
    ) {
        self::validateIfExistSite($id_site);
        self::validateExistRol($role);

        $user           = new User;
        $user->username = $username;
        $user->password = $password;
        $user->email    = $email;
        $user->role     = $role;
        $user->active   = true;
        $user->token    = uniqid();
        $user->save();

        $usuarioSite          = new UserSite;
        $usuarioSite->id_user = $user->id;
        $usuarioSite->id_site = $id_site;
        $usuarioSite->save();

        return "User registered successfully";
    }

}
