<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "jabatan".
 *
 * @property int $id_jabatan
 * @property string $jabatan
 * @property string $kode_jabatan
 */
class Jabatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jabatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan', 'kode_jabatan'], 'required'],
            [['jabatan'], 'string', 'max' => 250],
            [['kode_jabatan'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jabatan' => 'Id Jabatan',
            'jabatan' => 'Jabatan',
            'kode_jabatan' => 'Kode Jabatan',
        ];
    }
}
