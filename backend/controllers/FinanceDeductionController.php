<?php

namespace backend\controllers;

use backend\models\FinanceDeductionForm;
use backend\models\FinancePending;
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
use yii\helpers\Json;
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
                            'add-discount-by-adv',
                            'add-install-by-adv',
                            'add-fine-by-adv',
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
        return $this->renderAjax('view', [
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
        $model = new FinanceDeductionForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($this->saveDeduction($model)) {
                return $this->redirect(['index', 'id' => $model->id]);
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
        $model = new FinanceDeductionForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($this->saveDeduction($model)) {
                return $this->redirect(['index', 'id' => $model->id]);
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
        $model = new FinanceDeductionForm();

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

        //deduction_value可编辑,编辑之后修改相应的cost和revenue
        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $deduction_id = Yii::$app->request->post('editableKey');
            $deduction = FinanceDeduction::findOne($deduction_id);
            $old_deduction_value = $deduction->deduction_value;
            $old_deduction_cost = $deduction->deduction_cost;
            $old_deduction_revenue = $deduction->deduction_revenue;

            $out = Json::encode(['output' => '', 'message' => '']);

            $posted = current($_POST['FinanceDeduction']);
            $post = ['FinanceDeduction' => $posted];

            // load model like any single model validation
            if ($deduction->load($post)) {
                // can save model or do something before saving model
                $output = '';
                if (isset($posted['deduction_value'])) {
                    $output = $posted['deduction_value'];
                    $deduction_value = $posted['deduction_value'];

                    if ($deduction->type == 1) {
                        $deduction->deduction_cost = $deduction->cost * ($deduction_value / 100);
                        $deduction->deduction_revenue = $deduction->revenue * ($deduction_value / 100);
                    } else if ($deduction->type == 2) {
                        $deduction->deduction_cost = ($deduction->cost / $deduction->installs) * $deduction_value;
                        $deduction->deduction_revenue = $deduction->deduction_cost / (1 - $deduction->margin);
                    } else if ($deduction->type == 3) {
                        $deduction->deduction_cost = $deduction_value;
                        $deduction->deduction_revenue = $deduction->deduction_cost;
                    }
                }

                $deduction->save();
                $deduction->updateCost($old_deduction_cost,$old_deduction_revenue);
                $out = Json::encode(['output' => $output, 'message' => 'successifully saved']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 1;
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->renderAjax('update', [
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
        $model = new FinanceDeductionForm();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            if (empty($model->channel_id)) {
                $channel = Channel::findByUsername($model->channel_name);
                if (isset($channel)) {
                    $model->channel_id = $channel->id;
                }
            }
            $this->asJson(ActiveForm::validate($model));
        }
    }

    /**
     * @param FinanceDeductionForm $model
     * @return bool
     */

    private function saveDeduction(&$model)
    {
        date_default_timezone_set('Etc/GMT-8');
        $save = false;
        //加载channel_id;
        $channel = Channel::findByUsername($model->channel_name);
        $cam = Campaign::findById($model->campaign_id);
        strtotime($model->start_date);
        //加载report 数据；
        $start = strtotime($model->start_date);
        $end = strtotime($model->end_date);
        $model->start_date = $start;
        $model->end_date = $end;
//        var_dump($start);
//        var_dump($end);
//        var_dump($model->campaign_id);
//        var_dump($model->channel_name);
//        die();
        $channel_bill_id = $channel->id . '_' . date('Ym', $start);
        $adv_bill_id = $cam->advertiser0->id . '_' . date('Ym', $start);

        $records = CampaignLogHourly::findDateReport($start, $end + 3600 * 24, $model->campaign_id, $channel->id);
        if (!empty($records)) {
            $deduction = new FinanceDeduction();
            $deduction->channel_bill_id = $channel_bill_id;
            $deduction->adv_bill_id = $adv_bill_id;
            $deduction->channel_id = $channel->id;
            $deduction->campaign_id = $cam->id;
            $deduction->start_date = $start;
            $deduction->end_date = $end;
            $deduction->type = $model->type;
            $deduction->deduction_value = $model->deduction_value;
            $deduction->installs = $records->installs;
            $deduction->match_installs = $records->match_installs;
            $deduction->cost = $records->cost;
            $deduction->revenue = $records->revenue;
            $deduction->margin = $deduction->revenue == 0 ? 0 : ($deduction->revenue - $deduction->cost) / $deduction->revenue;
            $deduction->pm = empty(User::findIdentity($channel->pm)) ? null : User::findIdentity($channel->pm)->username;
            $deduction->om = User::findIdentity($channel->om)->username;
            $deduction->bd = User::findIdentity($cam->advertiser0->bd)->username;
            $deduction->adv = $cam->advertiser0->username;
            if ($deduction->type == 1) {
                $deduction->deduction_cost = $deduction->cost * ($deduction->deduction_value / 100);
                $deduction->deduction_revenue = $deduction->revenue * ($deduction->deduction_value / 100);
            } else if ($deduction->type == 2) {
                $deduction->deduction_cost = ($deduction->cost / $deduction->installs) * $deduction->deduction_value;
                $deduction->deduction_revenue = $deduction->deduction_cost / (1 - $deduction->margin);
            } else if ($deduction->type == 3) {
                $deduction->deduction_cost = $deduction->deduction_value;
                $deduction->deduction_revenue = $deduction->deduction_cost;
            }
//            var_dump($deduction);
//            die();
            if ($deduction->save()) {
                $save = true;
                $model->id = $deduction->id;

            } else {
                var_dump($deduction->getErrors());
                die();
            }
        }
        return $save;
    }

    /**
     * @param $campaign_id
     * @param $pending_id
     * @param $period
     * @param $channel_name
     * @return string|Response
     */
    public function actionAddInstallByAdv($campaign_id,$pending_id,$period,$channel_name)
    {
        $model = new FinanceDeductionForm();

        if ($model->load(Yii::$app->request->post())) {
            $this->saveDeduction($model);
            if(!empty($pending_id)){
                FinancePending::confirmPending($pending_id);
            }
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            $model->campaign_id = $campaign_id;
            $model->pending_id = $pending_id;
            $model->channel_name = $channel_name;
            $model->start_date = str_replace(".","-",explode("-",$period)[0]);
            $model->end_date = str_replace(".","-",explode("-",$period)[1]);
            return $this->renderAjax('add_install', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $campaign_id
     * @param $pending_id
     * @param $period
     * @param $channel_name
     * @return string|Response
     */
    public function actionAddDiscountByAdv($campaign_id,$pending_id,$period,$channel_name)
    {
        $model = new FinanceDeductionForm();

        if ($model->load(Yii::$app->request->post())) {
            $this->saveDeduction($model);
            if(!empty($pending_id)){
                FinancePending::confirmPending($pending_id);
            }
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            $model->campaign_id = $campaign_id;
            $model->pending_id = $pending_id;
            $model->channel_name = $channel_name;
            $model->start_date = str_replace(".","-",explode("-",$period)[0]);
            $model->end_date = str_replace(".","-",explode("-",$period)[1]);
            return $this->renderAjax('add_discount', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $campaign_id
     * @param $pending_id
     * @param $period
     * @param $channel_name
     * @return string|Response
     */
    public function actionAddFineByAdv($campaign_id,$pending_id,$period,$channel_name)
    {
        $model = new FinanceDeductionForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($this->saveDeduction($model)) {
                if(!empty($pending_id)){
                    FinancePending::confirmPending($pending_id);
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            $model->campaign_id = $campaign_id;
            $model->pending_id = $pending_id;
            $model->channel_name = $channel_name;
            $model->start_date = str_replace(".","-",explode("-",$period)[0]);
            $model->end_date = str_replace(".","-",explode("-",$period)[1]);
            return $this->renderAjax('add_fine', [
                'model' => $model,
            ]);
        }
    }

}
