<?php
namespace api\controllers;

use common\core\api\Controller;
use common\models\User;

/**
 * Site controller
 */
class UserController extends Controller
{
    public function actionGetInfo()
    { 
        $data=[];
        $data=User::loadUserInfoByUid($this->uid);
        return $this->renderJSON($data);
    }
}
