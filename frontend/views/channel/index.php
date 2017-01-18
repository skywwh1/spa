<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'firstname',
            'lastname',
            'type',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            // 'settlement_type',
            // 'pm',
            // 'om',
            // 'master_channel',
            // 'payment_way',
            // 'payment_term',
            // 'beneficiary_name',
            // 'bank_country',
            // 'bank_name',
            // 'bank_address',
            // 'swift',
            // 'account_nu_iban',
            // 'company_address',
            // 'system',
            // 'contacts',
            // 'created_time:datetime',
            // 'updated_time:datetime',
            // 'email:email',
            // 'cc_email:email',
            // 'company',
            // 'country',
            // 'city',
            // 'address',
            // 'phone1',
            // 'phone2',
            // 'wechat',
            // 'qq',
            // 'skype',
            // 'alipay',
            // 'lang',
            // 'timezone',
            // 'firstaccess',
            // 'lastaccess',
            // 'picture',
            // 'confirmed',
            // 'suspended',
            // 'deleted',
            // 'status',
            // 'traffic_source',
            // 'pricing_mode',
            // 'note',
            // 'post_back',
            // 'total_revenue',
            // 'payable',
            // 'paid',
            // 'strong_geo',
            // 'strong_catagory',

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
