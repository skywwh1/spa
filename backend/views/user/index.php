<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="user-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="user-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'username',
                            'firstname',
                            'lastname',
                            // 'auth_key',
                            // 'password_hash',
                            // 'password_reset_token',
                            // 'created_time:datetime',
                            // 'updated_time:datetime',
                            // 'status',
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
                            // 'suspended',
                            // 'deleted',

                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update} {resetpwd} {privilege}',
                                'buttons' => [
                                    'resetpwd' => function ($url, $model, $key) {
                                        $options = [
                                            'title' => Yii::t('yii', '重置密码'),
                                            'aria-label' => Yii::t('yii', '重置密码'),
                                            'data-pjax' => '0',
                                        ];
                                        return Html::a('<span class="glyphicon glyphicon-lock"></span>', $url, $options);
                                    },

                                    'privilege' => function ($url, $model, $key) {
                                        $options = [
                                            'title' => Yii::t('yii', '权限'),
                                            'aria-label' => Yii::t('yii', '权限'),
                                            'data-pjax' => '0',
                                        ];
                                        return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, $options);
                                    },

                                ],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>