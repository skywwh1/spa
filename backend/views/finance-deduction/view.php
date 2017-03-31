<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceDeduction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Deductions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="finance-deduction-index"></div>
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
                        'cost',
                        'deduction_value',
                        'deduction_cost',
                        'deduction_revenue',
                        'revenue',
                        'margin',
                        'adv',
                        'pm',
                        'bd',
                        'om',
                        [
                            'label' => 'Status',
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return ModelsUtil::getDeductionStatus($model->status);
                            }
                        ],
                        'note:text',
                        [
                            'attribute' => 'type',
                            'value' => function ($model) {
                                return ModelsUtil::getDeductionType($model->type);
                            }
                        ],
                        'create_time:datetime',
                        'update_time:datetime',
                    ],
                ]) ?>

            </div>
        </div>
    </div>
</div
