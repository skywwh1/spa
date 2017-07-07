<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RedirectLog */

$this->title = 'Redirect Logs Detail: ' . $model->campaign->campaign_name;
$this->params['breadcrumbs'][] = ['label' => 'Redirect Logs Detail', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign->campaign_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div id="nav-menu" data-menu="redirect-log-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'campaign_id',
                        'campaign.campaign_name',
                        'channel.username',
                        'campaign_id_new',
                        'campaignIdNew.campaign_name',
                        'discount',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return ModelsUtil::getRedirectStatus($model->status);
                            },
                        ],
                        'end_time:datetime',
                        'create_time:datetime',
                        'update_time:datetime',
                    ],
                ]) ?>

            </div>
        </div>
    </div>
</div
