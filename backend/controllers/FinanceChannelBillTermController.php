<?php

namespace backend\controllers;

use backend\models\FinanceAddCostSearch;
use backend\models\FinanceChannelPrepaymentSearch;
use backend\models\FinanceChannelCampaignBillTermSearch;
use backend\models\FinanceCompensation;
use backend\models\FinanceCompensationSearch;
use backend\models\FinanceDeduction;
use backend\models\FinanceDeductionSearch;
use backend\models\FinancePending;
use backend\models\FinancePendingSearch;
use backend\models\FinanceSubCostSearch;
use backend\models\InvoicePicture;
use backend\models\UploadForm;
use common\models\Channel;
use common\utility\MailUtil;
use common\utility\TimeZoneUtil;
use Yii;
use backend\models\FinanceChannelBillTerm;
use backend\models\FinanceChannelBillTermSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * FinanceChannelBillTermController implements the CRUD actions for FinanceChannelBillTerm model.
 */
class FinanceChannelBillTermController extends Controller
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
                        'actions' => ['view', 'index', 'create', 'update', 'delete', 'validate','edit','retreat','flow','upload','email'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all FinanceChannelBillTerm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceChannelBillTermSearch();
        $searchModel->start_time = TimeZoneUtil::initGMT8BeforeDate();
        $searchModel->end_time = TimeZoneUtil::initGMT8BeforeDate();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $summary = $searchModel->summarySearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'summary' => $summary,
        ]);
    }

    /**
     * Displays a single FinanceChannelBillTerm model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FinanceChannelBillTerm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FinanceChannelBillTerm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->bill_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinanceChannelBillTerm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->bill_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FinanceChannelBillTerm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FinanceChannelBillTerm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return FinanceChannelBillTerm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinanceChannelBillTerm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEdit($bill_id)
    {
        $model = $this->findModel($bill_id);
        $channel = Channel::findIdentity($model->channel_id);
        $upload = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {
//            $upload->imageFile = UploadedFile::getInstance($upload, 'imageFile');
//            var_dump($upload->imageFile);
//            die();
//            if (!$upload->upload()) {
//                // file is uploaded successfully
//                return;
//            }
            switch ($model->status)
            {
                case 3:
                    $compensation =  FinanceDeduction::findOne(['channel_bill_id' => $model->bill_id,'channel_id' => $model->channel_id]);
                    $model->payable -= $model->compensation;
                    FinanceCompensation::deleteAll(['deduction_id' => $compensation->id]);

                    $model->compensation = 0;
                    $model->status = 1;//对于reject的单子，一律设为pending状态
                    break;
                case 5:
                    $compensation =  FinanceDeduction::findOne(['channel_bill_id' => $model->bill_id,'channel_id' => $model->channel_id]);
                    $model->payable -= $model->compensation;
                    FinanceCompensation::deleteAll(['deduction_id' => $compensation->id]);

                    $model->compensation = 0;
                    $model->status = 1;//对于reject的单子，一律设为pending状态
                    break;
                default:
                    $model->status = $model->status;
            }
            if ($model->save()) {
                $this->asJson(['success' => 1]);
            } else {
                var_dump($model->getErrors());
            }
        } else {

            //payable
            $payableSearch = new FinanceChannelBillTermSearch();
            $payableSearch->bill_id = $bill_id;
            $payable = $payableSearch->payableSearch(Yii::$app->request->queryParams);
//            $payable = $payableSearch->search(Yii::$app->request->queryParams);

            //system cost
            $campaignBillSearchModel = new FinanceChannelCampaignBillTermSearch();
            $campaignBillSearchModel->bill_id = $bill_id;
            $campaignBill = $campaignBillSearchModel->financeChannelSearch(Yii::$app->request->queryParams);

            // confirmed
            $confirmSearchModel = new FinancePendingSearch();
            $confirmSearchModel->channel_bill_id_new = $bill_id;
            $confirmSearchModel->status = 1;
            $confirmList = $confirmSearchModel->financePendingSearch(Yii::$app->request->queryParams);

            // pending
            $pendingSearchModel = new FinancePendingSearch();
            $pendingSearchModel->channel_bill_id = $bill_id;
            $pendingSearchModel->status = 0;
            $pendingList = $pendingSearchModel->financePendingSearch(Yii::$app->request->queryParams);

            // deduction
            $deductionSearchModel = new FinanceDeductionSearch();
            $deductionSearchModel->channel_bill_id = $bill_id;
            $deductionList = $deductionSearchModel->financeDeductionSearch(Yii::$app->request->queryParams);

            //compensation
            $compensationSearchModel = new FinanceCompensationSearch();
            $compensationSearchModel->deduction_ids = FinanceDeduction::getDeductionIds($bill_id);
            $compensationList = $compensationSearchModel->detailSearch(Yii::$app->request->queryParams);

            //prepayment
            $prepaymentSearch = new FinanceChannelPrepaymentSearch();
            $prepaymentSearch->channel_bill_id = $bill_id;
            $prepaymentList = $prepaymentSearch->search(Yii::$app->request->queryParams);

            //add cost list
            $costSearch = new FinanceAddCostSearch();
            $costSearch->channel_bill_id = $bill_id;
            $costList = $costSearch->search(Yii::$app->request->queryParams);

            //sub cost list
            $subCostSearch = new FinanceSubCostSearch();
            $subCostSearch->channel_bill_id = $bill_id;
            $subCostList = $subCostSearch->search(Yii::$app->request->queryParams);

            $pics = InvoicePicture::findAll(['channel_bill_id' => $bill_id]);

            return $this->render('update', [
                'payable' => $payable,
                'model' => $model,
                'channel' => $channel,
                'campaignBill' => $campaignBill,
                'confirmList' => $confirmList,
                'pendingList' => $pendingList,
                'deductionList' => $deductionList,
                'compensationList' => $compensationList,
                'prepaymentList' => $prepaymentList,
                'costList' => $costList,
                'subCostList' => $subCostList,
                'upload'=>$upload,
                'searchModel' => $campaignBillSearchModel,
                'pics' => $pics
            ]);
        }
    }

    public function actionRetreat($id)
    {
        $bill = FinanceChannelBillTerm::findOne($id);
        $bill->status = 1;
        if ($bill->save()) {
            $this->asJson(['success' => 1]);
        } else {
            var_dump($bill->getErrors());
        }
    }

    /**
     * @param $bill_id
     * @param $multi
     * @return string
     */
    public function actionUpload($bill_id,$multi)
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
//            var_dump($_FILES['imageFiles']);
//            die();
//            var_dump($model->imageFiles );
            $pic = new InvoicePicture();
            $flag = 0;
            if ($multi == 1){
                $model->imageFiles = UploadedFile::getInstancesByName('imageFiles');
                foreach ( $model->imageFiles as $file) {
                    $url = Yii::$app->params['uploadInvoicePath'] . $file->baseName . '.' . $file->extension;
                    if($file->saveAs($url)){
                        $pic->path = '/upload/financeUpload/'. $file->baseName . '.' . $file->extension;
                        $pic->channel_bill_id = $bill_id;
                        $pic->save();
                        $flag = 1;
                    }
                }
                if ($flag == 1){
                    return '{}';
                }
            } else {
                $imageFile = UploadedFile::getInstanceByName('imageFile');
                $model->imageFile = $imageFile;
                $url = Yii::$app->params['uploadInvoicePath'] . $imageFile->baseName . '.' . $imageFile->extension;
                if($imageFile->saveAs($url)){
                    $bill = FinanceChannelBillTerm::findOne($bill_id);
                    $bill->invoice_path = '/upload/financeUpload/'. $imageFile->baseName . '.' . $imageFile->extension;
                    $bill->save();
                    return '{}';
                }
            }

//            if ($model->upload()) {
//                // file is uploaded successfully
//                return '{}';
//            }
        }
    }

    public function actionValidate()
    {
        $model = new FinanceChannelBillTerm();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            $billTerm = FinanceChannelBillTerm::findOne(['bill_id' => $model->channel_bill_id]);
            if (!empty($billTerm)) {
                $model->channel_id = $billTerm->channel_id;
            }
            $this->asJson(ActiveForm::validate($model));
        }
    }

    /**
     * @param $bill_id
     * @param $status
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionFlow($bill_id,$status)
    {
        $model = new FinanceChannelBillTerm();
        $model->bill_id = $bill_id;

        $model = $this->findModel($bill_id);
        //BD Leader Reject and Finance Reject will set status = pending
        switch ($status)
        {
            case 3:
                $model->status = 1;
                break;
            case 5:
                $model->status = 1;
                break;
            default:
                $model->status = $status;
        }
        if ( $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            var_dump($model->getErrors());
        }
    }

    /**
     * @param $bill_id
     */
    public function actionEmail($bill_id)
    {
        $campaignBillSearchModel = new FinanceChannelCampaignBillTermSearch();
        $campaignBillSearchModel->bill_id = $bill_id;
        $campaignBill = $campaignBillSearchModel->financeChannelSearch(Yii::$app->request->queryParams);
//        var_dump($campaignBill->getModels());
//        die();
        if (MailUtil::sendPayableConfirm($campaignBill->getModels())) {
            $this->asJson("send email success!");
        } else {
            $this->asJson("send email fail!");
        }
    }
}
