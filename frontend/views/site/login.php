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
<div class="col-sm-10">
    <div class="row">
            <?php $form = ActiveForm::begin(['fieldConfig' => [
    'template' => '<div class="form-group">
					   {label}
					   <div class="col-sm-3">
					       {input}
                            <span class="help-inline">{error}</span>
                        </div>
					</div>',
    'inputOptions' => ['class' => 'form-control'],
    'labelOptions' => ['class' => 'col-sm-2  control-label'],
],
'options' => ['class' => 'form-horizontal','id'=>'login-form']]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                	<div class="col-sm-offset-2 col-sm-10">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                	</div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
     </div>
</div>
