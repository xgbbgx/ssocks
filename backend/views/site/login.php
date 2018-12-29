<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin(['id' => 'login-form',
	    'options'=>['class'=>'form-vertical login-form'],
	    'fieldConfig' => [
	        'template' => "<div class=\"control-group\">{label}\n<div class=\"controls\">
			<div class=\"input-icon left\">{input}</div><span class=\"help-block\">{error}</span></div></div>",
	        'labelOptions' => ['class' => 'control-label visible-ie8 visible-ie9'],
	    ],
	]); ?>
		<?= $form->field($model, 'username',['inputTemplate' => '<i class="icon-user"></i>{input}',
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('username'),
                    ]])->textInput(['autofocus' => true,'class'=>'m-wrap placeholder-no-fix'])
                    ->label($model->getAttributeLabel('username')) ?>	
		<?= $form->field($model, 'password',['inputTemplate' => '<i class="icon-lock"></i>{input}',
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('password'),
                    ]])->passwordInput(['class'=>'m-wrap placeholder-no-fix','placeholder'=>$model->getAttributeLabel('password')])
                    ->label($model->getAttributeLabel('password')) ?>
		<?= $form->field($model, 'verifyCode')->widget(yii\captcha\Captcha::className()
		    ,['template' =>'<i class="icon-lock"></i>{input}{image}','options'=>['style'=>"width:100px;",
		        'class'=>"m-wrap placeholder-no-fix",'placeholder'=>$model->getAttributeLabel('verifyCode')],'imageOptions'=>['alt'=>'点击换图','title'=>'点击换图', 
                                            'style'=>'cursor:pointer']])->label(false) ?>
		<div class="form-actions">
			<?= $form->field($model, 'rememberMe')->checkbox(['style'=>'margin-left:0px;']) ?>
			<?= Html::submitButton('登陆', ['class' => 'btn green pull-right', 'name' => 'login-button']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
