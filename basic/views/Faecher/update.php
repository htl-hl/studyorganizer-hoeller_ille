<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Faecher $model */

$this->title = 'Update Faecher: ' . $model->F_Name;
$this->params['breadcrumbs'][] = ['label' => 'Faechers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->F_Name, 'url' => ['view', 'F_Name' => $model->F_Name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="faecher-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
