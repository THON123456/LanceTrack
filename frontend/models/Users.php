<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $password
 * @property string|null $hp
 * @property string $timestamps
 * @property string|null $NIK
 * @property string|null $role
 *
 * @property NotificationsMobile[] $notificationsMobiles
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timestamps'], 'safe'],
            [['name', 'email', 'password', 'hp', 'NIK', 'role'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['NIK'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'hp' => 'Hp',
            'timestamps' => 'Timestamps',
            'NIK' => 'Nik',
            'role' => 'Role',
        ];
    }

    /**
     * Gets query for [[NotificationsMobiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationsMobiles()
    {
        return $this->hasMany(NotificationsMobile::class, ['user_id' => 'id']);
    }
}
