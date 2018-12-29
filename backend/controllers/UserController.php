<?php

namespace backend\controllers;

use Yii;
use common\core\backend\Controller;
use common\models\User;
use common\helpers\UtilHelper;
use yii\bootstrap\Html;

class UserController extends Controller
{
    public function actionUserList()
    {
        return $this->render('user_list');
    }
    
    public function actionGetUserList(){
        $sEcho= empty($_GET['sEcho']) ? 0:intval($_GET['sEcho']);
        $colums=array("user.uid","user.username",'member.level','member.expired_time','member.status');
        $arr=UtilHelper::getDataTablesParams($_GET,$colums);
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 1,
            "iTotalDisplayRecords" => 1,
            "aaData" => array()
        );
        $iData=User::search($arr);
        $totalNum=empty($iData['totalNum']) ?0:$iData['totalNum'];
        $output['iTotalRecords']=$totalNum;
        $output['iTotalDisplayRecords']=$totalNum;
        if($totalNum){
            $userType=Yii::$app->params['user_conf']['level_conf'];
            $iList=empty($iData['list']) ?[]:$iData['list'];
            foreach($iList as $k=>$i){
                $id=$i['uid'];
                $img='<img style="width:80px;" src="/">';
                $action='
                <a  href="/user/user-view?uid='.$id.'"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;&nbsp;';
                $aaData=array($id,
                    //$img,
                    Html::encode($i['username']),
                    //Html::encode($i['nickname']),
                    empty($userType[$i['level']]) ? '':$userType[$i['level']],
                    date('Y-m-d H:i',$i['expired_time']),
                    $i['status'],
                    $action);
                $output['aaData'][]=$aaData;
            }
        }
        echo json_encode($output);
        exit;
    }
    public function actionUserView($uid){
        
        return $this->render('user_view',[
            'model' => UtilHelper::arrayToObject(User::loadUserInfoByUid($uid)),
        ]);
    }
}
