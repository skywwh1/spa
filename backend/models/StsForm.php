<?php
/**
 * Created by PhpStorm.
 * User: iven.wu
 * Date: 2/1/2017
 * Time: 12:29 PM
 */

namespace backend\models;


use yii\base\Model;

class StsForm extends Model
{

    public $campaign_uuid;
    public $channel;

    public function rules()
    {
        return [
            [['channel', 'campaign_uuid'], 'required'],
            [['channel', 'campaign_uuid'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campaign_uuid' => 'Campaign UUID',
            'channel' => 'Channel',
        ];
    }
}