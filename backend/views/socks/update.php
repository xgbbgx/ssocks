<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\socks\SocksIp */

$this->title = 'Update Socks Ip: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Socks Ips', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="socks-ip-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
