<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applicants List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div id="nav-menu" data-menu="applicants"></div>
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">


                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
                        'username',
//            'firstname',
//            'lastname',
                        // 'type',
                        // 'auth_key',
                        // 'password_hash',
                        // 'password_reset_token',
                        // 'settlement_type',
                        // 'account_name',
                        // 'branch_name',
                        // 'card_number',
                        // 'contacts',
                        // 'updated_at',
                        'email:email',
                        'country',
                        // 'city',
                        'address',
                        'company',
                        'phone1',
                        // 'phone2',
                        // 'wechat',
                        // 'qq',
                        'skype',
                        // 'alipay',
                        // 'lang',
                        'timezone',
                        'om',
                        // 'firstaccess',
                        // 'lastaccess',
                        // 'picture',
                        // 'confirmed',
                        // 'suspended',
                        // 'deleted',
                        // 'status',
                        // 'traffic_source',
                        // 'pricing_mode',
                        // 'post_back',
                        // 'strong_geo',
                        // 'strong_catagory',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Detail',
                            'template' => '{view-applicant}',
                            'buttons' => [
                                'view-applicant' => function ($url, $model) {
                                    return Html::a('view', $url, [
                                        'class' => 'btn btn-primary btn-xs',
                                        'title' => Yii::t('yii', 'Apply'),
                                    ]);
                                }
                            ],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{om-edit}',
                            'header' => 'Action',
                            'buttons' => [
                                'om-edit' => function ($url, $model) {
                                    return Html::a('editOM', null, [
                                        'class' => 'btn btn-primary btn-xs',
                                        'title' => Yii::t('yii', 'edit'),
                                        'data-method' => 'post',
                                        'data-pjax' => $url,
                                        'data-view' => '0',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJsFile('@web/js/editOM.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>