<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "drivers".
 *
 * @property int $id
 * @property string $email
 * @property string $nama
 * @property string $no_hp
 * @property string $password
 * @property string|null $role
 *
 * @property NotificationsDriver[] $notificationsDrivers
 */
class Drivers extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drivers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'nama', 'no_hp', 'password'], 'required'],
            [['role'], 'string'],
            [['email', 'nama', 'password'], 'string', 'max' => 255],
            [['no_hp'], 'string', 'max' => 20],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'nama' => 'Nama',
            'no_hp' => 'No Hp',
            'password' => 'Password',
            'role' => 'Role',
        ];
    }

    /**
     * Override beforeSave method to hash password before saving.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Hash the password if it is new or being updated
            if ($this->isNewRecord || $this->isAttributeChanged('password')) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }
}
