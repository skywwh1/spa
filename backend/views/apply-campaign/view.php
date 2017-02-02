<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ApplyCampaign */

$this->title = $model->campaign_id;
$this->params['breadcrumbs'][] = ['label' => 'Apply Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apply-campaign-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'campaign_id',
            'channel_id',
            'status',
            'create_time:datetime',
        ],
    ]) ?>

</div>
