<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdmUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adm-user-form">

    <?php $form = ActiveForm::begin([
 'fieldConfig' => [
    'template' => '<div class="control-group">
					   {label}
					   <div class="controls">
					       {input}
                            <span class="help-inline">{error}</span>
                        </div>
					</div>',
    'inputOptions' => ['class' => 'm-wrap medium'],
],
'options' => ['class' => 'form-horizontal','id'=>'form1','enctype'=>"multipart/form-data"],
]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'rpassword')->passwordInput(['maxlength' => true]) ?>
	
    <div class="form-actions">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
