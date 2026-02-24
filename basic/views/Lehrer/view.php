<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Lehrer $model */

$this->title = $model->L_ID;
$this->params['breadcrumbs'][] = ['label' => 'Lehrers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lehrer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'L_ID' => $model->L_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'L_ID' => $model->L_ID], [
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
            'L_ID',
            'Vorname',
            'Nachname',
            'Kuerzel',
            'Status',
        ],
    ]) ?>

</div>
