<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Faecher $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="faecher-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'F_Name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
