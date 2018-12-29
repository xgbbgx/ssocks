<?php
namespace common\core\api;
use Yii;
use common\core\base\BaseController;
use common\models\oauth\OauthToken;

/**
 * frontend 前端 Controller
 * @author Alex
 *
 */
class Controller extends BaseController
{
    public $accessToken;
    public $uid;//用户uid
    public function beforeAction($action){
        parent::beforeAction($action);
        $controllerId=Yii::$app->controller->id;
        $actionId=Yii::$app->controller->action->id;
        if($controllerId=='site' && $actionId=='error'){
            
        }else{
            $this->uid=$this->checkAccessToken();
            if($this->uid){
                
            }else{
                echo $this->renderJSON([],'10001');
                return false;
            }
        }
        return true;
    }
    protected function checkAccessToken(){
        $accessToken=empty($_REQUEST['access_token']) ?'':$_REQUEST['access_token'];
        if($accessToken){
            $oauth=OauthToken::loadUidByAccessToken($accessToken);
            $token=empty($_REQUEST['token']) ?'':$_REQUEST['token'];
            if(isset($oauth['token']) && $oauth['token']==$token){
                //清楚其他有效的accesstoken
                OauthToken::updateStatusByUid($oauth['uid'],$accessToken);
                $this->accessToken=$accessToken;
                return $oauth['uid'];
            }
        }
        return false;
    }
    protected function renderJSON($data=[], $code = 0, $msg ="") {
        header('Content-type: application/json');
        if($code){
            $msg=Yii::t('error', $code);
        }
        $jsonResult = json_encode([
            "code" => $code,
            "msg" => $msg,
            "data" => $data,
            "time" => time()
        ]);
        return $jsonResult;
    }
}