<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AdmUser */

$this->title = '创建后台用户';
$this->params['breadcrumbs'][] = ['label' => '后台用户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adm-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
