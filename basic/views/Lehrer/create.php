<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Lehrer $model */

$this->title = 'Create Lehrer';
$this->params['breadcrumbs'][] = ['label' => 'Lehrers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lehrer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
