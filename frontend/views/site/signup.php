<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">邮箱注册</label>
            <div class="col-sm-3">
              <input type="email" class="form-control" id="username" placeholder="邮箱注册">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">验证码</label>
            <div class="col-sm-2">
              <input class="form-control" id="verifyCode" placeholder="验证码">
            </div>
            <div class="col-sm-3">
              <img style="height: 45px;margin-left: -20px;" src="/site/captcha" onclick="refreshCaptcha();" id="verifycode-image">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">邮件验证码</label>
            <div class="col-sm-2">
              <input class="form-control" id="emailCode" placeholder="邮件验证码">
            </div>
             <div class="col-sm-3">
              <a class="btn green" href="javascript:void(0);" onclick="sendEmail(this)">发送邮件</a>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-3">
              <input type="password" class="form-control" id="password" placeholder="密码">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-3">
              <input type="password" class="form-control" id="r-password" placeholder="确认密码">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="button" class="btn btn-default" onclick='signup(this)'>注册</button>
            </div>
          </div>
        </form>
    </div>
</div>
<script>
    function refreshCaptcha() {
        var c_url = "/site/captcha?refresh=1";
        $.ajax({
            url: c_url,
            dataType: "json",
            success: function(data){
                $("#verifycode-image").attr("src", data.url);
            }
        });
    }
    function checkEmail(str){
    	if(typeof(str)!="undefined" && str ){
    		var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/;
    		if(reg.test(str)){
    			return true;
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
    function signup(e){
        var username=$("#username").val(),email_code=$("#emailCode").val(),
        password=$("#password").val(),r_passwor=$("#r-password").val();
        if(username && checkEmail(username)){
        }else{
        	wdialog.msgBox({msgType: 'error', html:'<?php echo Yii::t('error', '20103');?>',dialogWidth:'350px'});
            return;
        }
        if(email_code){
        }else{
        	wdialog.msgBox({msgType: 'error', html:'<?php echo Yii::t('error', '20104');?>',dialogWidth:'350px'});
            return;
        }
        if(password && password.length>=6 && password.length<=12){
        }else{
        	wdialog.msgBox({msgType: 'error', html:'<?php echo Yii::t('error', '20105');?>',dialogWidth:'350px'});
        	return;
        }
        if(r_passwor && password==r_passwor){
        }else{
        	wdialog.msgBox({msgType: 'error', html:'<?php echo Yii::t('error', '20106');?>',dialogWidth:'350px'});
        	return;
        }
        $(e).removeAttr('onclick');
        $.ajax({
        	'url':'/site/signup',
			'type':'POST',
			'data':{
				'username':username,
				'email_code':email_code,
				'password':password
			},
			'dataType':"json",
			'success':function(data){
				$(e).attr("onclick",'signup(this)');
				if(data.code=='00001'){
					 wdialog.msgBox({msgType: 'success', html:data.msg,dialogWidth:'350px'});
		             return;
				}else{
					wdialog.msgBox({msgType: 'error', html:data.msg,dialogWidth:'350px'});
		             return;
				}
			}
        });
    }
     function sendEmail(e){
         var verifyCode=$('#verifyCode').val();
         if(verifyCode){
         }else{
        	 wdialog.msgBox({msgType: 'error', html:'<?php echo Yii::t('error', '20101');?>',dialogWidth:'350px'});
             return;
         }
         $(e).removeAttr('onclick');
         $(e).html('邮件发送中...');
         $.ajax({
			'url':'/site/send-email',
			'type':'POST',
			'data':{
				'verifyCode':verifyCode
			},
			'dataType':"json",
			'success':function(data){
				$(e).attr("onclick",'sendEmail(this)');
				$(e).html('发送邮件');
				refreshCaptcha();
				$('#verifyCode').val('');
				if(data.code=='00001'){
					 wdialog.msgBox({msgType: 'success', html:data.msg,dialogWidth:'350px'});
		             return;
				}else{
					wdialog.msgBox({msgType: 'error', html:data.msg,dialogWidth:'350px'});
		             return;
				}
			}
         });
     }
</script>