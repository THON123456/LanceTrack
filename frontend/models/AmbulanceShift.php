<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ambulance_shift".
 *
 * @property int $id
 * @property string $nama_shift
 * @property int $waktu_shift_terakhir
 * @property int $pegawai_id
 */
class AmbulanceShift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ambulance_shift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_shift', 'waktu_shift_terakhir', 'pegawai_id'], 'required'],
            [['waktu_shift_terakhir', 'pegawai_id'], 'integer'],
            [['nama_shift'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_shift' => 'Nama Shift',
            'waktu_shift_terakhir' => 'Waktu Shift Terakhir',
            'pegawai_id' => 'Pegawai ID',
        ];
    }

    /**
     * Gets query for [[Pegawai]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'pegawai_id']);
    }

    public function getJabatan()
{
    return $this->hasOne(Jabatan::class, ['id_jabatan' => 'id_jabatan']);
}
}
