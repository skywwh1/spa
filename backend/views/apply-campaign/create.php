<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ApplyCampaign */

$this->title = 'Create Apply Campaign';
$this->params['breadcrumbs'][] = ['label' => 'Apply Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apply-campaign-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
