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

    <?= $form->field($model, 'Faelligkeitsdatum')->input('date', ['class' => 'form-control date-picker']) ?>

    <?= $form->field($model, 'Status')->dropDownList([ 'Open' => 'Open', 'Closed' => 'Closed']) ?>

    <?= $form->field($model, 'F_Name')->dropDownList($dropdownFaecher, ['prompt' => '']) ?>

    <?= $form->field($model, 'U_ID')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'L_ID')->dropDownList($dropdownLehrer, ['prompt' => '']) ?>


    <!--    --><?php //= $form->field($model, 'L_ID')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Erstellen', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
