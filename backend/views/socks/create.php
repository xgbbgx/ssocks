<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\socks\SocksIp */

$this->title = 'Create Socks Ip';
$this->params['breadcrumbs'][] = ['label' => 'Socks Ips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socks-ip-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
