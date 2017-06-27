<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "channel_update".
 *
 * @property integer $id
 * @property integer $channel_id
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property Channel $channel
 */
class ChannelUpdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel_update';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_id', 'create_time', 'update_time'], 'integer'],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id' => 'Channel ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }

    /**
     * @return array
     */
    public static function getRecentChannel()
    {
        $beginTheDayBefore=mktime(0,0,0,date('m'),date('d')-2,date('Y'));
        $query = new Query();
        $data = $query->select('channel.*')
            ->from('channel_update')
            ->leftJoin('channel','channel_update.channel_id = channel.id')
            ->andFilterWhere(['>','channel_update.create_time',$beginTheDayBefore])
            ->andFilterWhere(['channel.om' =>yii::$app->user->id])
            ->orderBy(['channel_update.create_time'=> SORT_ASC])
            ->all();
        return $data;
    }
}
