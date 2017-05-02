<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ApplyCampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applying Offers';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Modal::begin([
    'id' => 'campaign-detail-modal',
]);
echo '<div id="campaign-detail-content"></div>';
Modal::end(); ?>
    <div id="nav-menu" data-menu="apply-campaign-index"></div>
    <div class="row">
    <div class="apply-campaign-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="col-lg-12">
            <div class="box box-info table-responsive">
                <div class="box-body">
                    <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'id' => 'applying_list',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //  'campaign.campaign_name',
                            //'channel.username',
                            ['attribute' => 'campaignName',  'value' => 'campaign.campaign_name' ],
                            ['attribute' => 'channelName',  'value' => 'channel.username' ],
                            [
                                'attribute' => 'om',
                                'value' => 'channel.om0.username'
                            ],
                            [
                                'attribute' => 'status',
                                'value' => function ($data) {
                                    return ModelsUtil::getApplyStatus($data->status);
                                },
                                'filter' => ModelsUtil::apply_status,
                            ],
                            [
                                'attribute' => 'create_time',
                                'value' => function ($data) {
                                    return $data->create_time;
                                },
                                'filter' => false,
                                'format' => 'datetime',
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{apply}',
                                'header' => 'Action',
                                'buttons' => [
                                    'apply' => function ($url, $model) {
                                        if ($model->status !== 1) {
                                            $class = 'btn btn-primary btn-xs';
                                            $title = Yii::t('yii', 'Applying');
                                            switch ($model->status) {
//                                            case 1:
//                                                $class = 'btn btn-warning disabled btn-xs';
//                                                $title = Yii::t('yii', 'Applying');
//                                                break;
                                                case 2:
                                                    $class = 'btn btn-success disabled btn-xs';
                                                    $title = Yii::t('yii', 'Approved');
                                                    break;
                                                case 3:
                                                    $class = 'btn btn-danger disabled btn-xs';
                                                    $title = Yii::t('yii', 'Reject');
                                                    break;
                                            }
                                            return Html::a($title, '#', [
                                                'class' => $class,
                                                'title' => $title,
                                            ]);
                                        } else {
                                            return Html::a('applying', '#', [
                                                'class' => 'btn btn-primary btn-xs',
                                                'title' => Yii::t('yii', 'Applying'),
//                                                'data-method' => 'post',
//                                                'data-pjax' => 'w0',
                                                'data-view' => '0',
                                                'data-url' => $url,
                                            ]);
                                            //return Html::button('view', ['class' => 'btn btn-primary btn-xs', 'value' => $url, 'data-view' => 0]);
                                        }
                                    }
                                ],
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    return Url::toRoute(['/apply-campaign/deliver-create', 'channel_id' => $model->channel_id, 'campaign_id' => $model->campaign_id]);
                                }

                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->registerJsFile('@web/js/apply-campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>