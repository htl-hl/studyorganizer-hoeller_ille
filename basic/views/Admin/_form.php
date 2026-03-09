<?php
/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var bool $isUpdate */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$isUpdate = !$model->isNewRecord;
?>

<div class="user-form" style="max-width:520px;">

    <?php $form = ActiveForm::begin([
            'options' => ['autocomplete' => 'off'],
    ]); ?>

    <!-- Name -->
    <?= $form->field($model, 'Name', [
            'options' => ['class' => 'form-group'],
            'labelOptions' => ['class' => 'form-label'],
            'errorOptions' => ['class' => 'help-block'],
    ])->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => 'Benutzername eingeben',
            'autocomplete' => 'off',
    ])->label('Name') ?>

    <!-- Passwort -->
    <div class="form-group">
        <label class="form-label" for="pwd-input">
            Passwort
            <?php if ($isUpdate): ?>
                <span style="font-weight:400; color:var(--text-muted); font-size:.8rem; margin-left:.4rem;">
                    — leer lassen um es nicht zu ändern
                </span>
            <?php endif; ?>
        </label>
        <?= Html::activePasswordInput($model, 'Pwd', [
                'id'          => 'pwd-input',
                'class'       => 'form-control',
                'placeholder' => $isUpdate ? 'Neues Passwort (optional)' : 'Passwort eingeben',
                'autocomplete'=> 'new-password',
        ]) ?>
        <?php if ($model->hasErrors('Pwd')): ?>
            <div class="help-block"><?= Html::encode($model->getFirstError('Pwd')) ?></div>
        <?php endif; ?>
    </div>

    <!-- Admin-Checkbox -->
    <div class="form-group">
        <label class="form-label">Rolle</label>
        <div style="display:flex; align-items:center; gap:.75rem; padding:.6rem .85rem; border:1px solid var(--border); border-radius:var(--radius-sm); background:var(--surface);">
            <?= Html::activeCheckbox($model, 'is_admin', [
                    'label'        => false,
                    'id'           => 'is-admin-check',
                    'style'        => 'width:16px; height:16px; accent-color:var(--accent); cursor:pointer;',
                    'uncheck'      => '0',
                    'value'        => '1',
            ]) ?>
            <label for="is-admin-check" style="cursor:pointer; margin:0; font-size:.9rem;">
                Admin-Rechte vergeben
            </label>
        </div>
        <p style="font-size:.78rem; color:var(--text-muted); margin-top:.35rem;">
            Admins haben Zugriff auf die Benutzerverwaltung.
        </p>
    </div>

    <hr class="divider">

    <div style="display:flex; gap:.6rem;">
        <?= Html::submitButton(
                $isUpdate ? 'Änderungen speichern' : 'Benutzer erstellen',
                ['class' => 'btn btn-primary']
        ) ?>
        <?= Html::a('Abbrechen', $isUpdate
                ? ['view', 'U_ID' => $model->U_ID]
                : ['index'],
                ['class' => 'btn btn-outline']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>