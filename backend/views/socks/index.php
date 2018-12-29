<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Socks Ips';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socks-ip-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Socks Ip', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ip',
            'port',
            'protocol',
            'key',
            //'mode',
            //'transform_set',
            //'priority',
            //'location',
            //'tag',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            //'status',
            //'datafix',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
