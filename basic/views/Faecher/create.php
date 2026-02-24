<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Faecher $model */

$this->title = 'Create Faecher';
$this->params['breadcrumbs'][] = ['label' => 'Faechers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faecher-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
