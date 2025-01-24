<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class AmbulanceLocation extends ActiveRecord
{
    public static function tableName()
    {
        return 'ambulance_location';
    }

    public function rules()
    {
        return [
            [['ambulance_id', 'latitude', 'longitude'], 'required'],
            [['ambulance_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['timestamp'], 'safe'],
            [['nama', 'address'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ambulance_id' => 'Ambulance ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'timestamp' => 'Timestamp',
            'nama' => 'Nama',
            'address' => 'Address',
        ];
    }
}
