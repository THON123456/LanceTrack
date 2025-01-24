<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ambulance_maintenance".
 *
 * @property int $id
 * @property int $id_ambulance
 * @property string $keterangan
 * @property int $biaya
 * @property string $waktu
 */
class AmbulanceMaintenance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ambulance_maintenance';
    }
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ambulance', 'keterangan', 'biaya', 'waktu'], 'required'],
            [['id', 'id_ambulance', 'biaya'], 'integer'],
            [['waktu'], 'datetime', 'format' => 'php:Y-m-d H:i:s'], // Validasi datetime
            [['keterangan'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ambulance' => 'Id Ambulance',
            'keterangan' => 'Keterangan',
            'biaya' => 'Biaya',
            'waktu' => 'Waktu',
        ];
    }

    public function getAmbulance()
    {
        return $this->hasOne(Ambulance::class, ['id_ambulance' => 'id_ambulance']);
    }

}
