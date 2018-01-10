<?php

namespace App\models\resources;

use App\common\misc\Errors;
use App\common\transactions\UserTransaction;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Model
{
    const CREATE_USER                = 3;
    /*******************************************************/
    /*Se declaran las reglas del usuario*/
    /*******************************************************/
    const RULES = [
        0                                        => ["id" => "required|numeric"],
        UserResource::CREATE_USER                => [
            "username"                  => "bail|required",
            "password"                  => "bail|required",
            "role"                      => "bail|required|alpha",
            "new_password_confirmation" => "bail|required|same:password",
            "email"                     => "bail|required|email",
            "id_site"                   => "bail|required|numeric",
        ]
    ];

    public function validateInputs($request)
    {
        \Validator::extend('validateJson', function($field, $value, $parameters){
            return ((is_string($value) &&
            (is_object(json_decode($value)) ||
            is_array(json_decode($value))))) ? true : false;
        });

        $inputs = $request->all();
        foreach (UserResource::RULES[$this->action] as $key => $value) {
            if (!isset($inputs[$key])) {
                throw new \Exception(Errors::INCOMPLETE_OR_INVALID_PARAMS);
            }
        }

        $validateBeforeSaveUser = \Validator::make(
            $request->all(),
            UserResource::RULES[$this->action]
        );

        if ($validateBeforeSaveUser->fails()) {
            throw new \Exception(Errors::INCOMPLETE_OR_INVALID_PARAMS);
        }

        $this->request = $request;
    }

    public function validateId($id)
    {
        $validateBeforeSaveUser = \Validator::make(
            $id,
            UserResource::RULES[0]
        );

        if ($validateBeforeSaveUser->fails()) {
            throw new \Exception(Errors::INCOMPLETE_OR_INVALID_PARAMS);
        }

        $this->id = $id['id'];
    }

    public function readAndValidateParams($id, $input)
    {
        switch ($this->action) {
            case UserResource::GET_USER_PROFILE:
                $this->validateId(['id' => $id]);
                break;
        }

        switch ($this->action) {
            case UserResource::CREATE_USER:
                $this->validateInputs($input);
                break;
        }
    }

    public function doAction()
    {
        switch ($this->action) {
            case UserResource::CREATE_USER:
                return UserTransaction::createUser(
                    $this->request->username,
                    $this->request->password,
                    $this->request->email,
                    $this->request->role,
                    $this->request->id_site
                );
        }
    }
}
