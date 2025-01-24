<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Notification extends ActiveRecord
{
    public static function tableName()
    {
        return 'notifications'; // Pastikan nama tabel sesuai
    }

    public function rules()
    {
        return [
            [['user_id', 'message', 'url', 'created_at'], 'required'],
            [['user_id', 'is_read'], 'integer'],
            [['created_at'], 'safe'],
            [['message'], 'string'],
            [['url', 'status'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'url' => 'URL',
            'is_read' => 'Is Read',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
