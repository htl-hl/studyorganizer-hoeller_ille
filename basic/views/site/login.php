<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>

<style>
    /* Override layout padding for login — full page centered */
    body > div[style] { padding: 0 !important; max-width: 100% !important; }
</style>

<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo">Hausaufgaben<em>Manager</em></div>
        <p class="login-sub">Melde dich an, um deine Aufgaben zu verwalten.</p>

        <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['style' => 'width:100%'],
                'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'control-label'],
                        'inputOptions' => ['class' => 'form-control'],
                        'errorOptions' => ['class' => 'help-block'],
                        'options' => ['class' => 'form-group'],
                ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'placeholder' => 'Benutzername',
                'class' => 'form-control',
        ])->label('Benutzername') ?>

        <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => '••••••••',
                'class' => 'form-control',
        ])->label('Passwort') ?>

        <?= $form->field($model, 'rememberMe', [
                'template' => "{input} {label}\n{error}",
                'options' => ['class' => 'form-group', 'style' => 'display:flex;align-items:center;gap:.5rem;margin-bottom:1.25rem'],
                'labelOptions' => ['style' => 'text-transform:none;font-size:.875rem;font-weight:400;color:var(--text);margin:0;letter-spacing:0'],
                'inputOptions' => ['style' => 'width:auto;margin:0'],
        ])->checkbox()->label('Angemeldet bleiben') ?>

        <?= Html::submitButton('Anmelden', [
                'class' => 'btn btn-primary',
                'style' => 'width:100%;justify-content:center',
                'name' => 'login-button'
        ]) ?>

        <?php ActiveForm::end(); ?>

        <div class="login-footer">
            Noch kein Konto? <?= Html::a('Registrieren', ['/user/create']) ?>
        </div>
    </div>
</div>