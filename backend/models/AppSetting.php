<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "app_setting".
 *
 * @property int $id_app_setting
 * @property string $setting_name
 * @property int $is_image
 * @property string $value
 */
class AppSetting extends \yii\db\ActiveRecord
{
    public $image_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['setting_name', 'is_image', 'value'], 'required'],
            [['is_image'], 'integer'],
            [['image_file'], 'file', 'skipOnEmpty' => true, 'extensions'=>'jpg, jpeg, png, gif'],
            [['setting_name', 'value'], 'string', 'max' => 1500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_app_setting' => 'Id App Setting',
            'setting_name' => 'Setting Name',
            'is_image' => 'Image Status',
            'image_file' => 'Image Name',
            'value' => 'Value',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
//            *Disimpan dengan nama berbeda */
            $uploadedFile = UploadedFile::getInstance($this, 'image_file');
            if (!empty($uploadedFile)) {
                /*Model Penamaan dengan tanggal*/
                //$this->filename = strtotime(Timeanddate::getCurrentDateTime()) . '-' .$uploadedFile;
                /*Model Penamaan dengan mempertahankan nama aslinya*/
                //$this->filename = $this->id_sa_offline."_". $uploadedFile->baseName . '.' . $uploadedFile->extension;
                //Model Penamaan dengan default name dan id saja (agar kalau ada file baru langsung timpa di ID yang sama)
//                $this->file_image = "app_setting".$this->id_app_setting.'.' . $uploadedFile->extension;
                //Model Penamaan dengan setting name
                $this->image_file = $this->setting_name.'.' . $uploadedFile->extension;
				$this->value = $this->image_file;
				//$uploadedFile->saveAs('../web/images/app_setting/' . $this->image_file);
                $uploadedFile->saveAs('../../frontend/web/images/app_setting/' . $this->image_file);
                //$uploadedFile->saveAs('../../frontend/web/img/content/' . $this->image_filename);
                $this->save(false);
            }
            //this will save the image with new name
//            $path = Yii::getAlias('@backend').'/web/uploads/';
//            $uploadedFile->saveAs('uploads/news/' . $this->file_image);
//            $this->save(false);
            return true;
        } else {
            return false;
        }
    }
}
