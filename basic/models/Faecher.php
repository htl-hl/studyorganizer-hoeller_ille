<?php
/** @var yii\web\View $this */
/** @var app\models\Faecher $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$isUpdate = !$model->isNewRecord;
$this->title = $isUpdate ? 'Fach bearbeiten' : 'Neues Fach anlegen';
?>

<div class="page-header">
    <ul class="breadcrumb">
        <li><?= Html::a('Admin', ['index']) ?></li>
        <li><?= Html::a('Faecher', ['faecher']) ?></li>
        <li><?= $this->title ?></li>
    </ul>
    <h1><?= Html::encode($this->title) ?></h1>
</div>

<div style="max-width:400px;">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'F_Name', ['options' => ['class' => 'form-group']])->textInput([
        'maxlength'   => true,
        'class'       => 'form-control',
        'placeholder' => 'z.B. Mathematik',
        'readonly'    => $isUpdate,
    ])->label('Fachname') ?>

    <?php if ($isUpdate): ?>
        <p style="font-size:.78rem; color:var(--text-muted); margin-top:-.5rem; margin-bottom:1rem;">
            Der Fachname ist der Primaerschluessel und kann nicht geaendert werden.
        </p>
    <?php endif; ?>

    <hr class="divider">

    <div style="display:flex; gap:.6rem;">
        <?= Html::submitButton($isUpdate ? 'Speichern' : 'Anlegen', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Abbrechen', ['faecher'], ['class' => 'btn btn-outline']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>