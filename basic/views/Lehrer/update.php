<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Lehrer $model */

$this->title = 'Update Lehrer: ' . $model->L_ID;
$this->params['breadcrumbs'][] = ['label' => 'Lehrers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->L_ID, 'url' => ['view', 'L_ID' => $model->L_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lehrer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
