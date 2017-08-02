<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ReportMatchInstallHourly */

$this->title = $model->campaign_id;
$this->params['breadcrumbs'][] = ['label' => 'Report Match Install Hourlies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="report-match-install-hourly-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

    <p>
        <?= Html::a('Update', ['update', 'campaign_id' => $model->campaign_id, 'time' => $model->time], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'campaign_id' => $model->campaign_id, 'time' => $model->time], [
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
            'campaign_id',
            'time:datetime',
            'advertiser_id',
            'installs',
            'installs_in',
            'revenue',
            'update_time:datetime',
            'create_time:datetime',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
