<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Deliver */

$this->title = $model->campaign->campaign_name;
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="deliver_index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">

    <p>
        <?= Html::a('Update', ['update', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'campaign_id',
            'channel_id',
            'pricing_mode',
            'pay_out',
            'daily_cap',
            'discount',
            'is_run',
            'creator',
            'create_time:datetime',
            'update_time:datetime',
            'track_url:url',
            'note',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div>
