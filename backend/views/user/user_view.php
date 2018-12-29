<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '后台用户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adm-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->username], [
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
            [   'label'=>'UID',
                'attribute'=>'uid',
            ],
            [   'label'=>'用户名',
                'attribute'=>'username',
            ],
            [   'label'=>'状态',
                'attribute'=>'status',
            ],
            [   'label'=>'有效期',
                'attribute'=>'expired_time', 
                'value'=>date('Y-m-d H:i:s',$model->expired_time),
            ],
            [
                'attribute'=>'created_at',
                'label'=>'创建时间',
                'value'=>date('Y-m-d H:i:s',$model->created_at),
            ],
        ],
    ]) ?>

</div>
