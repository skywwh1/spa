<?php

namespace backend\controllers;

use common\models\Campaign;
use common\models\Deliver;
use common\models\Feed;
use Yii;
use common\models\Stream;
use common\models\StreamSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StreamController implements the CRUD actions for Stream model.
 */
class StreamController extends Controller
{
    public $layout = false;

    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['track', 'feed'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Stream models.
     * @return mixed
     */
//    public function actionIndex()
//    {
//        $searchModel = new StreamSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single Stream model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new Stream model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Stream();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing Stream model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Deletes an existing Stream model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Stream model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stream the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
//    protected function findModel($id)
//    {
//        if (($model = Stream::findOne($id)) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }

    public function actionTrack()
    {
        $model = new Stream();
        $data = Yii::$app->request->getQueryParams();
        //array(3) { ["pl"]=> string(3) "ios" ["ch_id"]=> string(2) "22" ["cp_uid"]=> string(5) "sdfsd" }
        $allParameters = '';
        if (isset($data)) {
            foreach ($data as $k => $v) {
                $allParameters .= $k . '=' . $v . '&';
            }
        }


        if (isset($allParameters)) {
            $model->all_parameters = $allParameters;
        }
        $model->click_uuid = uniqid() . uniqid();
        $model->click_id = isset($data['click_id']) ? $data['click_id'] : null;
        $model->ch_id = isset($data['ch_id']) ? $data['ch_id'] : null;
        $model->pl = isset($data['pl']) ? $data['pl'] : null;
        $model->cp_uid = isset($data['cp_uid']) ? $data['cp_uid'] : null;
        $model->ip = Yii::$app->request->getUserIP();

        $echoStr = "error message : ";
        if (!$model->validate() && $model->hasErrors()) {
            foreach ($model->getErrors() as $k => $v) {
                $echoStr .= implode("", $v) . "</br>";
            }

        } else {
            $model->save();
            $camp = Campaign::findByUuid($model->cp_uid);
            if (isset($camp)) {
                $deliver = Deliver::findIdentity($camp->id, $model->ch_id);
                if (isset($deliver)) {
                    $link = $camp->adv_link;
                    if (strpos($link, '?') !== false) {
                        $link .= '&';
                    } else {
                        $link .= '?';
                    }
                    $post_param = $deliver->campaign->advertiser0->post_parameter;
                    if (!empty($post_param)) {
                        $link .= $post_param . '=' . $model->click_uuid;
                    } else {
                        $link .= 'click_id=' . $model->click_uuid;
                    }
                    return $this->redirect($link);
                }
            }
        }

        echo $echoStr;
        die();
    }

    public function actionFeed()
    {
        $model = new Feed();
        $data = Yii::$app->request->getQueryParams();
        $model->click_id = isset($data['click_id']) ? $data['click_id'] : null;
        $model->ch_id = isset($data['ch_id']) ? $data['ch_id'] : null;
        if (isset($data['click_id'])) {
            $model->save();
        }
        die();
    }
}
