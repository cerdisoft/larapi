<?php

namespace App\common\misc;

class Errors 
{
    const INCOMPLETE_OR_INVALID_PARAMS = 0;
    const USER_NOT_FOUND = 1;
    const SITE_NOT_FOUND = 2;
    const ROLE_NOT_REGISTERED = 3;
    const VALIDATE_USERNAME_IN_SITE = 4;
    const USER_IN_SITE_NOT_EXIST = 5;
    const WRONG_PASSWORD = 6;
    const WRONG_USERNAME = 7;
    const WRONG_OLD_PASSWORD = 8;    

    public static function getErrorDetails($id) 
    {
        switch ($id) {
            case self::INCOMPLETE_OR_INVALID_PARAMS:
                return "At least one parameter is valid or missing";
            case self::USER_NOT_FOUND:
                return "User not found";
            case self::SITE_NOT_FOUND:
                return "Site not found";
            case self::ROLE_NOT_REGISTERED:
                return "Role not registered";
            case self::VALIDATE_USERNAME_IN_SITE:
                return "There was an error when validating the user and the site";
            case self::USER_IN_SITE_NOT_EXIST:
                return "User in site not exist";
            case self::WRONG_PASSWORD:
                return "Wrong password";
            case self::WRONG_USERNAME:
                return "Wrong username";
            case self::WRONG_OLD_PASSWORD:
                return "Wrong old password";            
            default :
                throw new \Exception("Error code not defined");
        }
    }
}