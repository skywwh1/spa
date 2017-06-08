<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Channel */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="my_channels"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">

                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'username',
                        'auth_token',
//            'team',
//            'firstname',
//            'lastname',
//            'type',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
//            'settlement_type',
                        //'om',
                        [
                            'attribute' => 'om',
                            'value' => isset($model->om0) ? $model->om0->username : "",
                        ],
                        //'master_channel',
                        [
                            'attribute' => 'master_channel',
                            'value' => isset($model->masterChannel) ? $model->masterChannel->username : "",
                        ],
                        'payment_way',
                        [
                            'attribute' => 'payment_term',
                            'value' => function ($model) {
                                return ModelsUtil::getPaymentTerm($model->payment_term);
                            }
                        ],
                        'beneficiary_name',
                        'bank_country',
                        'bank_name',
                        'bank_address',
                        'swift',
                        'account_nu_iban',
                        'company_address',
                        'discount',
                        'note',
                        'contacts',
                        'created_time:datetime',
                        'updated_time:datetime',
                        'email:email',
                        'cc_email:email',
                        'country',
//            'city',
//            'address',
                        'company',
                        'phone1',
//            'phone2',
//            'wechat',
//            'qq',
                        'skype',
//            'alipay',
//            'lang',
//            'timezone',
//            'firstaccess',
//            'lastaccess',
//            'picture',
//            'confirmed',
//            'suspended',
//            'deleted',
//            'bd',
                        'system',
//                        [
//                            'attribute' => 'system',
//                            'value' => ModelsUtil::getSystem($model->system)
//                        ],
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
                        'pricing_mode',
//                        [
//                            'attribute' => 'pricing_mode',
//                            'value' => ModelsUtil::getPricingMode($model->pricing_mode)
//                        ],
                        'post_back',
                        'total_revenue',
                        'payable',
                        'paid',
//                        [
//                            'attribute' => 'os',
//                            'value' => ModelsUtil::getPlatform($model->os)
//                        ],
                        'os',
                        'strong_geo',
                        'strong_category',
                        [
                            'attribute' => 'recommended',
                            'value' => ModelsUtil::getStatus($model->recommended)
                        ],
                    ],
                ]) ?>

            </div>
        </div>
    </div>
</div>