<?php
namespace common\core\backend;

use common\core\base\BaseController;

/**
 * frontend 前端 Controller
 * @author Alex
 *
 */
class Controller extends BaseController
{
    public function beforeAction($action){
        $this->getView()->title=ucwords(\Yii::$app->controller->id);
        return true;
    }
}