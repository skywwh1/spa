<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Channel */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-view">

    <h3><?= Html::encode($this->title) ?></h3>

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
            'username',
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
            'payment_term',
            'beneficiary_name',
            'bank_country',
            'bank_name',
            'bank_address',
            'swift',
            'account_nu_iban',
            'company_address',
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
            //'traffic_source',
            [
                'attribute' => 'traffic_source',
                'value' => ModelsUtil::getTrafficeSource($model->traffic_source)
            ],
            //'pricing_mode',
            [
                'attribute' => 'pricing_mode',
                'value' => ModelsUtil::getPricingMode($model->pricing_mode)
            ],
            'post_back',
            'total_revenue',
            'payable',
            'paid',
            'strong_geo',
            'strong_catagory',
        ],
    ]) ?>

</div>
