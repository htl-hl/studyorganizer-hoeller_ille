<?php
/** @var yii\web\View $this */
/** @var app\models\User $model */

use yii\helpers\Html;

$this->title = 'Neuer Benutzer';
?>

    <div class="page-header">
        <ul class="breadcrumb">
            <li><?= Html::a('Admin', ['/admin/index']) ?></li>
            <li><?= Html::a('Benutzer', ['index']) ?></li>
            <li>Neu erstellen</li>
        </ul>
        <h1>Neuer <em style="font-style:italic; font-weight:300;">Benutzer</em></h1>
    </div>

<?= $this->render('_form', ['model' => $model]) ?>