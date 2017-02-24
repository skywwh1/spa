<?php
namespace backend\controllers;

use common\models\Advertiser;
use common\models\Campaign;
use common\models\Channel;
use common\models\SignupForm;
use common\models\User;
use linslin\yii2\curl\Curl;
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
                        'actions' => ['logout', 'index', 'forget', 'test','info'],
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
        $this->layout='admin_login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/info']);
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

    public function actionInfo(){
        $this->layout = 'admin_layout';
        return $this->render('info');
    }
    public function actionTest(){


        $cache = Yii::$app->cache;
        $cache->delete('cache_data_key');
        $data = $cache->get('cache_data_key');
        if ($data === false) {
            //这里我们可以操作数据库获取数据，然后通过$cache->set方法进行缓存
            $cacheData = 'ppp';
    //set方法的第一个参数是我们的数据对应的key值，方便我们获取到
    //第二个参数即是我们要缓存的数据
    //第三个参数是缓存时间，如果是0，意味着永久缓存。默认是0
        }
        $c = Channel::findOne(['id'=>29]);
        $cache->set('cache_data_key', $c, 5);
//        var_dump($data);

        die();
//        $aa = Advertiser::find()->where(['auth_token'=>null])->all();
//        foreach($aa as $item){
//            $item->auth_token = uniqid('adv').uniqid();
//            $item->save();
//        }
//
//        $bb = Channel::find()->where(['auth_token'=>null])->all();
//        foreach($bb as $item){
//            $item->auth_token = uniqid('ch').uniqid();
//            $item->save();
//        }
//        var_dump($aa);
    }
}
