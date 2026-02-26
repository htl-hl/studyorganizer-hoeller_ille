<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Faecher $model */

$this->title = $model->F_Name;
$this->params['breadcrumbs'][] = ['label' => 'Faechers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="faecher-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'F_Name' => $model->F_Name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'F_Name' => $model->F_Name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'F_Name',
        ],
    ]) ?>

</div>
