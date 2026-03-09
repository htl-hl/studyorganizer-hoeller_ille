<?php
/** @var yii\web\View $this */
/** @var app\models\User $model */

use yii\helpers\Html;

$this->title = 'Benutzer bearbeiten: ' . Html::encode($model->Name);
?>

    <div class="page-header">
        <ul class="breadcrumb">
            <li><?= Html::a('Admin', ['/admin/index']) ?></li>
            <li><?= Html::a('Benutzer', ['index']) ?></li>
            <li><?= Html::a(Html::encode($model->Name), ['view', 'U_ID' => $model->U_ID]) ?></li>
            <li>Bearbeiten</li>
        </ul>
        <h1>
            <em style="font-style:italic; font-weight:300;">Bearbeiten:</em>
            <?= Html::encode($model->Name) ?>
        </h1>
    </div>

<?= $this->render('_form', ['model' => $model]) ?>