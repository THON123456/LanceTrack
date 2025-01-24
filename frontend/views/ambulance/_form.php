<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Ambulance $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ambulance-form">

    <?php $form = ActiveForm::begin(); ?>

       <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
       
        <?= $form->field($model, 'plat_nomor')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'tipe')->dropDownList(
        [
            'Mobil Transportasi' => 'Mobil Transportasi',
            'Mobil Jenazah' => 'Mobil Jenazah',
            
            // Tambahkan tipe yang Anda perlukan di sini
        ],
        ['prompt' => 'Select Tipe']
    ) ?>

<?= $form->field($model, 'status')->dropDownList(
        [
            '0' => 'Ready',
            '1' => 'Maintenance',
            
            // Tambahkan tipe yang Anda perlukan di sini
        ],
        ['prompt' => 'Select Status']
    ) ?>


 

    <?= $form->field($model, 'fotoFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
