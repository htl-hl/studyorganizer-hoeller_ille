<?php

use app\models\Hausaufgaben;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\HausaufgabenSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Hausaufgabens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hausaufgaben-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Hausaufgaben', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'HU_ID',
            'Titel',
            'Beschreibung:ntext',
            'Faelligkeitsdatum',
            'Status',
            //'F_Name',
            //'U_ID',
            //'L_ID',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Hausaufgaben $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'HU_ID' => $model->HU_ID]);
                 }
            ],
        ],
    ]); ?>


</div>
