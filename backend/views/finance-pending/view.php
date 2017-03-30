<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FinancePending */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Pendings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="finance-pending-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'campaign_id',
                        'campaign.campaign_name',
                        'channel_id',
                        'channel.username',
                        'start_date:datetime',
                        'end_date:datetime',
                        'installs',
                        'match_installs',
//            'adv_price',
//            'pay_out',
                        'cost',
                        'revenue',
                        'margin',
                        'adv',
                        'pm',
                        'bd',
                        'om',
                        [
                            'label' => 'status',
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return ModelsUtil::getPendingStatus($model->status);
                            },
                        ],
                        'note:text',
                        'create_time:datetime',
                    ],
                ]) ?>

            </div>
        </div>
    </div>
</div
