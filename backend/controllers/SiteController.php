<?php
namespace backend\controllers;

use common\models\Campaign;
use common\models\SignupForm;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = "login_layout";

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'forget', 'test', 'signup','captcha'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'forget', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
              //  'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
               // 'backColor'=>0x000000,//背景颜色
                'maxLength' => 6, //最大显示个数
                'minLength' => 4,//最少显示个数
//                'padding' => 10,//间距
                'height'=>35,//高度
                'width' => 130,  //宽度
//                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>5,        //设置字符偏移量 有效果
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['channel/index']);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['channel/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionForget()
    {
        $this->layout = false;
        return $this->render('forget');
    }

    public function actionSignup()
    {
        $this->layout = 'login_layout';
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signUp()) {
            return $this->redirect(['login']);
        } else {
            return $this->render('signup', [
                'model' => $model,
            ]);
        }
    }

    public function actionTest($uuid){
        $a=$uuid;
//        var_dump($a);
//        die();
//        var_dump(Campaign::getCampaignsByUuid($a));
        die();
    }
}
