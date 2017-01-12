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
            'om',
            'main_channel',
            'account_name',
            'branch_name',
            'card_number',
            'contacts',
            'created_time:datetime',
            'updated_time:datetime',
            'email:email',
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
            'firstaccess',
            'lastaccess',
//            'picture',
//            'confirmed',
            'suspended',
            'deleted',
//            'bd',
            'system',
            'status',
            'cc_email:email',
            'traffic_source',
            'pricing_mode',
            'note',
            'app_id',
            'post_back',
            'click_pram_name',
            'click_pram_length',
            'total_revenue',
            'need_pay',
            'already_pay',
        ],
    ]) ?>

</div>
