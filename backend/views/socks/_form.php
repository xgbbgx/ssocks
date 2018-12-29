<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\socks\SocksIp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="socks-ip-form">

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

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'port')->textInput() ?>

    <?= $form->field($model, 'protocol')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'key')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'mode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transform_set')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'priority')->textInput() ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-actions">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
