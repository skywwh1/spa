<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MyCart */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'My Carts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="my-cart-view"></div>
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
            'campaign_id',
            'campaign_name',
            'target_geo',
            'platform',
            'payout_currency',
            'daily_cap',
            'traffic_source',
            'tag',
            'direct',
            'advertiser',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
