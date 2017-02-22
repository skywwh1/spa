<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\mail\MessageInterface;

/**
 * This is the model class for table "send_mail_log".
 *
 * @property integer $id
 * @property string $to_who
 * @property string $creator
 * @property integer $is_send
 * @property string $content
 * @property string $type
 * @property integer $create_time
 */
class SendMailLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'send_mail_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_send', 'create_time'], 'integer'],
            [['content', 'type'], 'string'],
            [['to_who'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'to_who' => 'To Who',
            'creator' => 'Creator',
            'is_send' => 'Is Send',
            'content' => 'Content',
            'type' => 'Type',
            'create_time' => 'Create Time',
        ];
    }

    public static function saveMailLog(MessageInterface $mail, $param)
    {
        $log = new SendMailLog();
        $log->type = ArrayHelper::getValue($param, 'type');
        $log->is_send = ArrayHelper::getValue($param, 'isSend');
        $log->create_time = time();

        $user = isset(Yii::$app->user) ? Yii::$app->user->getId() : null;
        $log->creator = $user;

        $log->to_who = implode(array_keys($mail->getTo()));
        $log->content = $mail->toString();
        $log->save();
    }
}
