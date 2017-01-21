<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CampaignChannelLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Approved Offers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-channel-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'campaign_uuid',
//            'adv_price',
            'pricing_mode',
             'pay_out',
             'daily_cap',
//             'actual_discount',
//             'discount',
             'is_run',
//             'creator',
//             'create_time:datetime',
//             'update_time:datetime',
//             'track_url:url',
             'click',
             'unique_click',
             'install',
//             'cvr',
//             'cost',
//             'match_install',
//             'match_cvr',
//             'revenue',
//             'def',
//             'deduction_percent',
//             'profit',
//             'margin',
//             'note',

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
