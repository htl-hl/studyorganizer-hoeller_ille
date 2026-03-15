<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LehrerSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lehrer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'L_ID') ?>

    <?= $form->field($model, 'Vorname') ?>

    <?= $form->field($model, 'Nachname') ?>

    <?= $form->field($model, 'Kuerzel') ?>

    <?= $form->field($model, 'Status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
