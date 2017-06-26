<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_spa_mapping".
 *
 * @property integer $id
 * @property integer $spa_campaign_id
 * @property integer $tr_de_id
 * @property integer $actived
 */
class LogSpaMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_spa_mapping';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spa_campaign_id', 'tr_de_id'], 'required'],
            [['spa_campaign_id', 'tr_de_id', 'actived'], 'integer'],
            [['spa_campaign_id'], 'unique'],
            [['tr_de_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'spa_campaign_id' => 'Spa Campaign ID',
            'tr_de_id' => 'Tr De ID',
            'actived' => 'Actived',
        ];
    }
}
