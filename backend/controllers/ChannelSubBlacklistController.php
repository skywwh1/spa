<?php

namespace backend\controllers;

use common\models\Channel;
use Yii;
use common\models\ChannelSubBlacklist;
use common\models\ChannelSubBlacklistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChannelSubBlacklistController implements the CRUD actions for ChannelSubBlacklist model.
 */
class ChannelSubBlacklistController extends Controller
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
     * Lists all ChannelSubBlacklist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelSubBlacklistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ChannelSubBlacklist model.
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
     * Creates a new ChannelSubBlacklist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ChannelSubBlacklist();

        if ($model->load(Yii::$app->request->post())) {
            $this->beforeCreate($model);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ChannelSubBlacklist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->beforeUpdate($model);

        if ($model->load(Yii::$app->request->post())) {
            $this->beforeCreate($model);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ChannelSubBlacklist model.
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
     * Finds the ChannelSubBlacklist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChannelSubBlacklist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ChannelSubBlacklist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param ChannelSubBlacklist $model
     */
    private function beforeCreate(&$model)
    {
        if (!empty($model->channel_name)) {
            $user = Channel::findByUsername($model->channel_name);
        }
        $model->channel_id = isset($user) ? $user->id : null;

        if (!empty($model->os)) {
            $model->os = implode(',', $model->os);
        }

        if (!empty($model->geo)) {
            $model->geo = implode(',', $model->geo);
        }

        if (!empty($model->category)) {
            $model->category = implode(',', $model->category);
        }
    }

    /**
     * @param ChannelSubBlacklist $model
     */
    private function beforeUpdate(&$model)
    {
        $model->channel_name = $model->channel->username;

        if (!empty($model->geo)) {
            $model->geo = explode(',', $model->geo);
        }

        if (!empty($model->category)) {
            $model->category = explode(',', $model->category);
        }

        if (!empty($model->os)) {
            $model->os = explode(',', $model->os);
        }
    }


}
