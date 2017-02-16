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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'campaign_id',
            'channel.username',
            'pricing_mode',
            'pay_out',
            'daily_cap',
            'discount',
//            'status',
            [
                'attribute'=>'status',
                'value'=>ModelsUtil::getCampaignStatus($model->status)
            ],
            [
                'attribute'=>'creator',
                'value'=>$model->creator0->username,
            ],
            'end_time:datetime',
            'create_time:datetime',
            'update_time:datetime',
            [
                    'attribute'=>'track_url',
                'value'=>\yii\helpers\Url::to('@track'.$model->track_url),
                'format'=>'url'
            ],
            'note:text',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div>
