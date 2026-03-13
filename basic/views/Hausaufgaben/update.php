<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Hausaufgaben $model */

$this->title = 'Update Hausaufgaben: ' . $model->HU_ID;
?>
<div class="hausaufgaben-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
            'dropdownLehrer' => $dropdownLehrer,
            'dropdownFaecher' => $dropdownFaecher,
    ]) ?>

</div>
