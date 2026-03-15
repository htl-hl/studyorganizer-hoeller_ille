<?php

use app\models\Faecher;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\FaecherSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Faechers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faecher-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Faecher', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'F_Name',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Faecher $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'F_Name' => $model->F_Name]);
                 }
            ],
        ],
    ]); ?>


</div>
