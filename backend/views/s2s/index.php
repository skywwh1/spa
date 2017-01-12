<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\S2sSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'S2s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="s2s-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create S2s', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'campaign_id',
            'channel_id',
            'pay_out',
            'daily_cap',
            'discount',
            // 'is_run',
            // 'create_time:datetime',
            // 'update_time:datetime',
            // 'note',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
