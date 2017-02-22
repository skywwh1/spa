<?php

namespace api\modules\v1\controllers;

use api\auth\QueryParamAuth;
use yii\rest\ActiveController;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class CountryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Country';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' =>QueryParamAuth::className(),
        ];

        return $behaviors;
    }
}


