<?php

namespace backend\controllers;

use backend\models\TestLinkForm;
use common\models\Campaign;
use common\models\Channel;
use common\models\Stream;
use linslin\yii2\curl\Curl;
use Yii;
use common\models\Deliver;
use common\models\DeliverSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * DeliverController implements the CRUD actions for Deliver model.
 */
class DeliverController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Deliver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Deliver model.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionView($campaign_id, $channel_id)
    {
//        return $this->render('view', [
//            'model' => $this->findModel($campaign_id, $channel_id),
//        ]);

        $searchModel = new DeliverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Deliver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Deliver();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->step == 1) {
                $model->setCampaignIdBy($model->campaign_uuid);
                $model->setChannelIdBy($model->channel0);
                $model->adv_price = isset($model->campaign) ? $model->campaign->adv_price : 0;
                return $this->render('second', [
                    'model' => $model,
                ]);
            } else if ($model->step == 2) {
                if ($model->save()) {
                    return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]);
                } else {
                    return $this->render('second', [
                        'model' => $model,
                    ]);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Deliver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionUpdate($campaign_id, $channel_id)
    {
        $model = $this->findModel($campaign_id, $channel_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Deliver model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionDelete($campaign_id, $channel_id)
    {
        $this->findModel($campaign_id, $channel_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Deliver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return Deliver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($campaign_id, $channel_id)
    {
        if (($model = Deliver::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTestlink()
    {
        $model = new TestLinkForm();

        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            $channel = Channel::findChannelByName($model->channel);
            if (empty($channel)) {
                return "Can found channel";
            }
            $t = time();
            $curl = new Curl();
            if ($curl->get($model->tracking_link) !== false) {
                $stream = Stream::getLatestClick($channel->id, $t);
                $link = Channel::genPostBack($channel->post_back, $stream->all_parameters);
                $curl = new Curl();
                if ($curl->get($link) !== false) {
                    return "Post back success";
                }

            } else {
                return "Test fail";
            }

        } else {
            return $this->render('test_link', [
                'model' => $model,
            ]);
        }
    }
}
