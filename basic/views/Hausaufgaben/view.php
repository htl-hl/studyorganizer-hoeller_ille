<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Hausaufgaben $model */

$this->title = $model->HU_ID;
$this->params['breadcrumbs'][] = ['label' => 'Hausaufgabens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="hausaufgaben-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'HU_ID' => $model->HU_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'HU_ID' => $model->HU_ID], [
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
            'HU_ID',
            'Titel',
            'Beschreibung:ntext',
            'Faelligkeitsdatum',
            'Status',
            'F_Name',
                [
                        'attribute' => 'U_ID',
                        'label' => 'User',
                        'value' => function ($model) {
                            return $model->user ? $model->user->Name : 'Nicht zugewiesen';
                        },
                ],
                [
                        'attribute' => 'L_ID',
                        'label' => 'Lehrer',
                        'value' => function ($model) {
                            return $model->lehrer ? $model->lehrer->Nachname : 'Nicht zugewiesen';
                        },
                ],
        ],
    ]) ?>

</div>
