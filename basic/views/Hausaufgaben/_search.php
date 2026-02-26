<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\HausaufgabenSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="hausaufgaben-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'HU_ID') ?>

    <?= $form->field($model, 'Titel') ?>

    <?= $form->field($model, 'Beschreibung') ?>

    <?= $form->field($model, 'Faelligkeitsdatum') ?>

    <?= $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'F_Name') ?>

    <?php // echo $form->field($model, 'U_ID') ?>

    <?php // echo $form->field($model, 'L_ID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
