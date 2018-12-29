<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\socks\SocksIp */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Socks Ips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socks-ip-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ip',
            'port',
            'protocol',
            'key',
            'mode',
            'transform_set',
            'priority',
            'location',
            'tag',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'status',
            'datafix',
        ],
    ]) ?>

</div>
