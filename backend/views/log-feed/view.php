<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\LogFeed */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Feeds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="log-feed-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

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
            'auth_token',
            'click_uuid',
            'click_id',
            'channel_id',
            'campaign_id',
            'ch_subid',
            'all_parameters:ntext',
            'ip',
            'adv_price',
            'feed_time:datetime',
            'is_post',
            'create_time:datetime',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
