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
<div id="nav-menu" data-menu="advertiser-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info  table-responsive">
            <div class="box-body">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [

                        'id',
                        'username',
//                        'settlement_type',
                        [
                            'attribute' => 'settlement_type',
                            'value' => function ($data) {
                                return ModelsUtil::getSettlementType($data->settlement_type);
                            },
                            'filter' => ModelsUtil::settlement_type,
                        ],
                        [
                            'attribute' => 'bd',
                            'value'=> 'bd0.username',
                            'filter' => false,
                        ],

                        'system',
                        [
                            'attribute' => 'status',
                            'value' => function ($data) {
                                return ModelsUtil::getAdvertiserStatus($data->status);
                            },
                            'filter' => ModelsUtil::advertiser_status,
                        ],
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

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}{update}'
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

