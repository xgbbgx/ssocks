<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\category\Category */


	$this->title = '修改密码';
	$this->params['breadcrumbs'][] = $model->username;
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption"><i class="icon-reorder"></i><?= Html::encode($this->title) ?></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="#portlet-config" data-toggle="modal" class="config"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<h3 class="block"><?= Html::encode($this->title) ?></h3>
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

		<?= $form->field($model, 'username')->textInput(['disabled'=>'disabled']) ?>
		<?= $form->field($model, 'nickname')->textInput() ?>
		<?= $form->field($model, 'email')->textInput() ?>
		<?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'new_password')->textInput() ?>
		<div class="form-actions">
			<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
</div>
