<?php

use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anti Cheat CVR';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="deliver_index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info ">
            <div class="box-body">
                <p>&nbsp;&nbsp; &nbsp;The CVR for the following channels are high, here’re actions made:</p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pjax' => true, // pjax is set to always true for this demo
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        'campaign_id',
                        'campaign.campaign_name',
                        'channel.username',
                        'match_install',
                        'match_cvr',
                        'action',
                        'pm',
                        'bd',
                        'om'
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>