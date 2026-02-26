<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Lehrer $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lehrer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Vorname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Nachname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Kuerzel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
