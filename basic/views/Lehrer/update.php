<?php
/** @var yii\web\View $this */
/** @var app\models\Lehrer $model */

use yii\helpers\Html;

$this->title = 'Lehrer bearbeiten: ' . Html::encode($model->Vorname) . ' ' . Html::encode($model->Nachname);
?>

    <div class="page-header">
        <ul class="breadcrumb">
            <li><?= Html::a('Admin', ['/admin/index']) ?></li>
            <li><?= Html::a('Lehrer', ['index']) ?></li>
            <li>Bearbeiten</li>
        </ul>
        <h1><em style="font-style:italic; font-weight:300;">Bearbeiten:</em> <?= Html::encode($model->Vorname) ?> <?= Html::encode($model->Nachname) ?></h1>
    </div>

<?= $this->render('_form', ['model' => $model]) ?>