<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Channel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'firstname',
            'lastname',
            'type',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'settlement_type',
            'pm',
            'om',
            'master_channel',
            'payment_way',
            'payment_term',
            'beneficiary_name',
            'bank_country',
            'bank_name',
            'bank_address',
            'swift',
            'account_nu_iban',
            'company_address',
            'system',
            'contacts',
            'created_time:datetime',
            'updated_time:datetime',
            'email:email',
            'cc_email:email',
            'company',
            'country',
            'city',
            'address',
            'phone1',
            'phone2',
            'wechat',
            'qq',
            'skype',
            'alipay',
            'lang',
            'timezone',
            'firstaccess',
            'lastaccess',
            'picture',
            'confirmed',
            'suspended',
            'deleted',
            'status',
            'traffic_source',
            'pricing_mode',
            'note',
            'post_back',
            'total_revenue',
            'payable',
            'paid',
            'strong_geo',
            'strong_catagory',
        ],
    ]) ?>

</div>
