<?php

namespace backend\controllers;

use common\models\Campaign;
use common\models\CampaignLogHourly;
use common\models\Channel;
use common\models\User;
use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;
use backend\models\FinanceDeduction;
use backend\models\FinanceDeductionSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * FinanceDeductionController implements the CRUD actions for FinanceDeduction model.
 */
class FinanceDeductionController extends Controller
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
                            'update',
                            'add-discount',
                            'add-install',
                            'add-fine',
                            'view',
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
     * Lists all FinanceDeduction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceDeductionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinanceDeduction model.
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
     * Creates a new FinanceDeduction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FinanceDeduction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new FinanceDeduction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddDiscount()
    {
        $model = new FinanceDeduction();

        if ($model->load(Yii::$app->request->post())) {
            if ($this->saveDeduction($model)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('add_discount', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new FinanceDeduction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddInstall()
    {
        $model = new FinanceDeduction();

        if ($model->load(Yii::$app->request->post())) {
            if ($this->saveDeduction($model)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('add_install', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new FinanceDeduction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddFine()
    {
        $model = new FinanceDeduction();

        if ($model->load(Yii::$app->request->post())) {
            if ($this->saveDeduction($model)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('add_fine', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinanceDeduction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FinanceDeduction model.
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
     * Finds the FinanceDeduction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinanceDeduction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinanceDeduction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidate()
    {
        $model = new FinanceDeduction();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            if (empty($model->channel_id)) {
                $channel = Channel::findByUsername($model->channel_name);
                if (isset($channel)) {
                    $model->channel_id = $channel->id;
                }
            }
            if (!is_int($model->start_date)) {
                $start = new DateTime($model->start_date, new DateTimeZone('Etc/GMT-8'));
                $model->start_date = $start->getTimestamp();
            }
            if (!is_int($model->end_date)) {
                $end = new DateTime($model->end_date, new DateTimeZone('Etc/GMT-8'));
                $model->end_date = $end->getTimestamp();
            }
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * @param FinanceDeduction $model
     * @return bool
     */

    private function saveDeduction(&$model)
    {
        $save = false;
        //加载channel_id;
        $channel = Channel::findByUsername($model->channel_name);
        $cam = Campaign::findById($model->campaign_id);
        //加载report 数据；
        $start = new DateTime($model->start_date, new DateTimeZone('Etc/GMT-8'));
        $end = new DateTime($model->end_date, new DateTimeZone('Etc/GMT-8'));
        $model->start_date = $start->getTimestamp();
        $model->end_date = $end->getTimestamp();
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
//        var_dump($start);
//        var_dump($end);
//        var_dump($model->campaign_id);
//        var_dump($model->channel_name);
//        die();
        $records = CampaignLogHourly::findDateReport($start, $end, $model->campaign_id, $model->channel_id);
        if (isset($records)) {
            $model->channel_id = $channel->id;
            $model->installs = $records->installs;
            $model->match_installs = $records->match_installs;
            $model->cost = $records->cost;
            $model->revenue = $records->revenue;
            $model->margin = $model->revenue == 0 ? 0 : ($model->revenue - $model->cost) / $model->revenue;
            $model->pm = empty(User::findIdentity($channel->pm)) ? null : User::findIdentity($channel->pm)->username;
            $model->om = User::findIdentity($channel->om)->username;
            $model->bd = User::findIdentity($cam->advertiser0->bd)->username;
            $model->adv = $cam->advertiser0->username;
            if ($model->type == 1) {
                $model->deduction_cost = $model->cost * ($model->deduction_value / 100);
            } else if ($model->type == 2) {
                $model->deduction_cost = ($model->cost / $model->installs) * $model->deduction_value;

            } else if ($model->type == 3) {
                $model->deduction_cost = $model->deduction_value;
            }
            if ($model->save()) {
                $save = true;
            } else {
                var_dump($model->getErrors());
                die();
            }
        }
        return $save;
    }
}
