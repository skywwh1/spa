<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Channel */
/* @var $register frontend\models\ChannelRegister */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Applicants List ', 'url' => ['applying']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="applicants"></div>
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-header ui-sortable-handle">
                <h3 class="box-title">Base Info</h3>
            </div>
            <div class="box-body">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'username',
                        'created_time:datetime',
                        'updated_time:datetime',
                        'email:email',
                        'cc_email:email',
                        'country',
//            'city',
                        'address',
                        'company',
                        'phone1',
//            'phone2',
//            'wechat',
//            'qq',
                        'skype',
//            'alipay',
//            'lang',
//            'timezone',
                        //'system',
                        [
                            'attribute' => 'system',
                            'value' => ModelsUtil::getSystem($model->system)
                        ],
                        //'status',
                        [
                            'attribute' => 'status',
                            'value' => ModelsUtil::getAdvertiserStatus($model->status)
                        ],
                        'traffic_source',
//                        [
//                            'attribute' => 'traffic_source',
//                            'value' => ModelsUtil::getTrafficeSource($model->traffic_source)
//                        ],
                    ],
                ]) ?>

            </div>
        </div>
    </div>
<?php if (isset($register)) { ?>
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
                <h3 class="box-title">Register Info</h3>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $register,
                    'attributes' => [
                        'vertical',
                        'offer_type',
                        'other_network',
                        'vertical_interested',
                        'special_offer',
                        'regions',
                        'traffic_type',
                        'best_time',
                        'time_zone',
                        'suggested_am',
                        'additional_notes',
                        'another_info',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
<?php } ?>