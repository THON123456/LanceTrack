<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pegawai".
 *
 * @property int $id_pegawai
 * @property string $nama
 * @property string $nip
 * @property string $alamat
 * @property int $id_jabatan
 */
class Pegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'nip', 'alamat', 'id_jabatan'], 'required'],
            [['id_jabatan'], 'integer'],
            [['nama', 'alamat'], 'string', 'max' => 250],
            [['nip'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pegawai' => 'ID Pegawai',
            'nama' => 'Nama',
            'nip' => 'Nip',
            'alamat' => 'Alamat',
            'id_jabatan' => 'Id Jabatan',
        ];
    }

    public function getJabatan()
    {
        return $this->hasOne(Jabatan::class, ['id_jabatan' => 'id_jabatan']);
    }
}
