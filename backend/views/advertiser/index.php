<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AdvertiserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Advertiser List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertiser-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'username',
            'team',
             'settlement_type',
             'bd',
             'system',
             'status',
            // 'contacts',
            'pricing_mode',
            'created_time:datetime',
            // 'type',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            // 'updated_at',
            // 'email:email',
            // 'company',
            // 'phone1',
            // 'phone2',
            // 'weixin',
            // 'qq',
            // 'skype',
            // 'alipay',
            // 'country',
            // 'city',
            // 'address',
            // 'lang',
            // 'timezone',
            // 'firstaccess',
            // 'lastaccess',
            // 'picture',
            // 'confirmed',
            // 'suspended',
            // 'deleted',
            // 'cc_email:email',
            // 'traffic_source',
             'note',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
