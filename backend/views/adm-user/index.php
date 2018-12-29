<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '后台用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adm-user-index">
    <p>
        <?= Html::a('创建后台用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            'nickname',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            [
                'attribute' => 'status',
                'value' =>  function ($model, $key, $index, $column){
                    if($model->status=='10'){
                        return '激活';
                    }else{
                        return '失效';
                    }
                }
            ],
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
