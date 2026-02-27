<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Hausaufgaben $model */

$this->title = 'Update Hausaufgaben: ' . $model->HU_ID;
$this->params['breadcrumbs'][] = ['label' => 'Hausaufgabens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->HU_ID, 'url' => ['view', 'HU_ID' => $model->HU_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hausaufgaben-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
