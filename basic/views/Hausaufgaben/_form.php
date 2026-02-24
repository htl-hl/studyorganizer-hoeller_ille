<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Hausaufgaben $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="hausaufgaben-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Titel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Beschreibung')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'Faelligkeitsdatum')->textInput() ?>

    <?= $form->field($model, 'Status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'F_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'U_ID')->textInput() ?>

    <?= $form->field($model, 'L_ID')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
