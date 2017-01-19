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


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel', 'tracking_link', 'type'], 'required'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'channel' => 'Channel',
            'tracking_link' => 'Tracking Link',
        ];
    }

}
