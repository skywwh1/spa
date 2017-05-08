<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div id="nav-menu" data-menu="channel_index"></div>
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">


                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
                        'id',
                        'username',
//            'firstname',
//            'lastname',
                        // 'type',
                        // 'auth_key',
                        // 'password_hash',
                        // 'password_reset_token',
                        // 'settlement_type',
                        [
                            'attribute' => 'om',
                            'value' => 'om0.username',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'master_channel',
                            'value' => 'masterChannel.username',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'os',
                            'value' => 'os',
                            'filter' =>false,
                        ],
                        // 'account_name',
                        // 'branch_name',
                        // 'card_number',
                        // 'contacts',
                        // 'updated_at',
                        'email:email',
                        // 'country',
                        // 'city',
                        // 'address',
                        // 'company',
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
//                        'status',
                        [
                            'attribute' => 'status',
                            'value' => function ($data) {
                                return ModelsUtil::getAdvertiserStatus($data->status);
                            },
                            'filter' => ModelsUtil::advertiser_status,
                        ],

                        // 'traffic_source',
                        // 'pricing_mode',
                        // 'post_back',
                        'total_revenue',
                        'payable',
                        'paid',
                        'note:text',
                        [
                            'attribute' => 'recommended',
                            'value' => function ($data) {
                                return ModelsUtil::getStatus($data->recommended);
                            },
                            'filter' => ModelsUtil::status,
                        ],
                        // 'strong_geo',
                        // 'strong_catagory',

                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{view}{update}'
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>