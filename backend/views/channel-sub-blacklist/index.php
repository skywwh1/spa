<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelSubBlacklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel Sub Blacklists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="channel-sub-blacklist-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="channel-sub-blacklist-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('Create Channel Sub Blacklist', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [

                            [
                                // 'label' => 'id',
                                'attribute' => 'id',
                                'value' => 'id',
                            ],
                            [
                                // 'label' => 'channel_id',
                                'attribute' => 'channel_id',
                                'value' => 'channel_id',
                            ],
                            [
                                // 'label' => 'channel_id',
                                'attribute' => 'channel_name',
                                'value' => 'channel.username',
                            ],
                            [
                                // 'label' => 'sub_channel',
                                'attribute' => 'sub_channel',
                                'value' => 'sub_channel',
                            ],
                            [
                                // 'label' => 'geo',
                                'attribute' => 'geo',
                                'value' => 'geo',
                            ],
                            [
                                // 'label' => 'os',
                                'attribute' => 'os',
                                'value' => 'os',
                            ],
                            [
//                             'label' => 'category',
                             'attribute' => 'category',
                             'value' => 'category',
                             ],
                            [
                                // 'label' => 'create_time',
                                'attribute' => 'create_time',
                                'value' => 'create_time',
                                'format' => 'datetime',
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{view}{update}{delete}',
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>