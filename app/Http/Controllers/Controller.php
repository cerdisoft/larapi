<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\models\resources\UserResource;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function doAction($action, $id = false, $input = array())
    {
        $resource = new UserResource;
        $resource->action = $action;
        $response = [];
        try{
            $resource->readAndValidateParams($id, $input);
            $response["success"] = true;
            $response["details"] = $resource->doAction();
        }catch (\Exception $e) {
            $response["success"] = false;
            $response["details"] = $e->getMessage();
        }

        return $response;
    }
}
