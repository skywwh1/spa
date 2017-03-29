<?php

namespace backend\controllers;

use common\models\Deliver;
use Yii;
use common\models\RedirectLog;
use common\models\RedirectLogSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * RedirectLogController implements the CRUD actions for RedirectLog model.
 */
class RedirectLogController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'create',
                            'validate',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all RedirectLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RedirectLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RedirectLog model.
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
     * Creates a new RedirectLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $campaign_id
     * @param $channel_id
     * @return mixed
     */
    public function actionCreate($campaign_id, $channel_id)
    {
        $model = RedirectLog::findIsActive($campaign_id, $channel_id);
//        var_dump($model);
//        die();
        if (empty($model)) {
            $model = new RedirectLog();
            $model->campaign_id = $campaign_id;
            $model->channel_id = $channel_id;
        }
        if (Yii::$app->getRequest()->isPost && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $sts = Deliver::findIdentity($campaign_id, $channel_id);
                if ($model->status == '1') {
                    $sts->is_redirect = 1;
                } else {
                    $sts->is_redirect = 0;
                }
                if ($sts->save()) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['success' => $model->save()];
                } else {
                    var_dump($sts->getErrors());
                }
            } else {
                var_dump($model->getErrors());
            }
//            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RedirectLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RedirectLog model.
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
     * Finds the RedirectLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RedirectLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RedirectLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidate()
    {
        $model = new RedirectLog();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
}
