<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delivers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deliver-index">

    <h3>Report List</h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'campaign.campaign_name',
            'channel.username',
            'campaign_uuid',
            'adv_price',
            'pricing_mode',
             'pay_out',
             'daily_cap',
            // 'actual_discount',
             'discount',
            // 'is_run',
            // 'creator',
            // 'create_time:datetime',
            // 'update_time:datetime',
            // 'track_url:url',
            // 'click',
            // 'unique_click',
            // 'install',
             'cvr',
             'cost',
             'match_install',
             'match_cvr',
             'revenue',
             'def',
             'deduction_percent',
             'profit',
             'margin',
             'note',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
