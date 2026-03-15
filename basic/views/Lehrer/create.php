<?php
/** @var yii\web\View $this */
/** @var app\models\Lehrer $model */

use yii\helpers\Html;

$this->title = 'Neuen Lehrer anlegen';
?>

    <div class="page-header">
        <ul class="breadcrumb">
            <li><?= Html::a('Admin', ['/admin/index']) ?></li>
            <li><?= Html::a('Lehrer', ['index']) ?></li>
            <li>Neu anlegen</li>
        </ul>
        <h1>Neuen <em style="font-style:italic; font-weight:300;">Lehrer</em> anlegen</h1>
    </div>

<?= $this->render('_form', ['model' => $model]) ?>