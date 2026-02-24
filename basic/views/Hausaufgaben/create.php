<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Hausaufgaben $model */

$this->title = 'Create Hausaufgaben';
$this->params['breadcrumbs'][] = ['label' => 'Hausaufgabens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hausaufgaben-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
