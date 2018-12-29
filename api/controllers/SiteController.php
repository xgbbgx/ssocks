<?php
namespace api\controllers;

use common\core\api\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionError()
    { 
        return $this->renderJSON([],'404');
    }
}
