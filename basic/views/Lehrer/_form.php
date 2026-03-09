<?php
/** @var yii\web\View $this */
/** @var app\models\Lehrer $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$isUpdate = !$model->isNewRecord;
$this->title = $isUpdate ? 'Lehrer bearbeiten' : 'Neuen Lehrer anlegen';
?>

<div class="page-header">
    <ul class="breadcrumb">
        <li><?= Html::a('Admin', ['index']) ?></li>
        <li><?= Html::a('Lehrer', ['lehrer']) ?></li>
        <li><?= $this->title ?></li>
    </ul>
    <h1><?= Html::encode($this->title) ?></h1>
</div>

<div style="max-width:520px;">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Vorname', ['options' => ['class' => 'form-group']])->textInput([
            'maxlength' => true,
            'class'     => 'form-control',
            'placeholder' => 'Vorname',
    ]) ?>

    <?= $form->field($model, 'Nachname', ['options' => ['class' => 'form-group']])->textInput([
            'maxlength' => true,
            'class'     => 'form-control',
            'placeholder' => 'Nachname',
    ]) ?>

    <?= $form->field($model, 'Kuerzel', ['options' => ['class' => 'form-group']])->textInput([
            'maxlength' => true,
            'class'     => 'form-control',
            'placeholder' => 'z.B. SCH',
    ]) ?>

    <div class="form-group">
        <label class="form-label">Status</label>
        <?= Html::activeDropDownList($model, 'Status', [
                'Aktiv'   => 'Aktiv',
                'Inaktiv' => 'Inaktiv',
        ], [
                'class'  => 'form-control',
                'prompt' => 'Status auswaehlen',
        ]) ?>
    </div>

    <hr class="divider">

    <div style="display:flex; gap:.6rem;">
        <?= Html::submitButton($isUpdate ? 'Speichern' : 'Anlegen', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Abbrechen', ['lehrer'], ['class' => 'btn btn-outline']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>