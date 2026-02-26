<?php

use app\models\Lehrer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\LehrerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lehrers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lehrer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Lehrer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'L_ID',
            'Vorname',
            'Nachname',
            'Kuerzel',
            'Status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Lehrer $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'L_ID' => $model->L_ID]);
                 }
            ],
        ],
    ]); ?>


</div>
