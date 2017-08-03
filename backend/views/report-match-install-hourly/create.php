<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ReportMatchInstallHourly */

$this->title = 'Create Report Match Install Hourly';
$this->params['breadcrumbs'][] = ['label' => 'Report Match Install Hourlies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="report-match-install-hourly-create"></div>
<div class="report-match-install-hourly-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
