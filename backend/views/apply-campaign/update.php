<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ApplyCampaign */

$this->title = 'Update Apply Campaign: ' . $model->campaign_id;
$this->params['breadcrumbs'][] = ['label' => 'Apply Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign_id, 'url' => ['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="apply-campaign-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
