<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ApiCampaigns */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Api Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-campaigns-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'adv_id',
            'url:url',
            'key',
            'param',
            'json_offers_param',
            'adv_update_time',
            'effective_time',
            'adv_campaign_id',
            'campaign_uuid',
            'campaign_name',
            'pricing_mode',
            'promote_start',
            'end_time',
            'platform',
            'daily_cap',
            'adv_price',
            'daily_budget',
            'target_geo',
            'adv_link',
            'traffice_source',
            'note:ntext',
            'preview_link',
            'icon',
            'package_name',
            'app_name',
            'app_size',
            'category',
            'version',
            'app_rate',
            'description',
            'creative_link',
            'creative_type',
            'creative_description',
            'carriers',
            'conversion_flow',
            'status',
            'create_time:datetime',
            'update_time:datetime',
        ],
    ]) ?>

</div>
