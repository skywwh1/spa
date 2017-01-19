<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class TestLinkForm extends Model
{
    public $channel;
    public $tracking_link;
    public $result;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel', 'tracking_link', 'type'], 'required'],
            ['tracking_link', 'url', 'defaultScheme' => 'http'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'channel' => 'Channel',
            'tracking_link' => 'Tracking Link',
            'result' => 'Result',
        ];
    }

}
