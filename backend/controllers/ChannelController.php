<?php

namespace backend\controllers;

use common\models\Campaign;
use common\models\User;
use Yii;
use common\models\Channel;
use common\models\ChannelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChannelController implements the CRUD actions for Channel model.
 */
class ChannelController extends Controller
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
     * Lists all Channel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Channel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Channel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Channel();

        if ($model->load(Yii::$app->request->post())) {
            $user = User::findByUsername($model->om);
            $model->om = isset($user) ? $user->id : "";
            $main_chan = Channel::findChannelByName($model->main_channel);
            $model->main_channel = isset($main_chan) ? $main_chan->id : null;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Channel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->om = User::findByUsername($model->om)->id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Channel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Channel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Channel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Channel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGet_channel_name($name)
    {
        return \JsonUtil::toTypeHeadJson(Channel::getChannelNameListByName($name));
    }

    public function actionGet_om($om)
    {
        return \JsonUtil::toTypeHeadJson(User::getOMList($om));
    }

///*****************************************************************************************
    public function actionTest()
    {
        echo "aaa";
        $mail = \Yii::$app->mailer->compose()
            ->setTo('evan_wu95@126.com')
            ->setSubject('邮件发送配置')
            //->setTextBody('Yii中文网教程真好 www.yii-china.com')   //发布纯文字文本
            ->setHtmlBody("<br>Yii中文网教程真好！www.yii-china.com")//发布可以带html标签的文本
            ->send();
        if ($mail)
            echo 'success';
        else
            echo 'fail';
        echo "kk";
        die();
        return $this->render('test');
    }

    public function actionAjaxtest()
    {
        $data = "TTT";
        return $data;
    }

    public function actionTestpage($uuid = null)
    {
        echo Campaign::getCampaignsByUuid($uuid);
    }


}
