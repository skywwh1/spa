<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel List';
$this->params['breadcrumbs'][] = $this->title;
$columns = [];
?>
<?php echo $this->render('_search', ['model' => $searchModel]);
if (!empty($dataProvider)) {
?>
<div class="row">
    <div id="nav-menu" data-menu="search_channel"></div>
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                        'username',
                        [
                            'attribute' => 'om_name',
                            'value' => 'om0.username',
                        ],
                        [
                            'attribute' => 'level',
                            'value' => function ($model) {
                                return ModelsUtil::getChannelLevel($model->level);
                            }
                        ],
                        'traffic_source',
                        [
                            'attribute' => 'os',
                            'filter' => \common\models\Platform::find()
                                ->select(['name', 'value'])
                                ->orderBy('id')
                                ->indexBy('value')
                                ->column()
                        ],
                        'strong_geo',
                        'strong_category',
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>