<?php

namespace app\controllers;

use app\models\Lehrer;
use app\models\LehrerSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class LehrerController extends Controller
{
    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
            $this->layout = '@app/views/layouts/admin';
        }
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => \yii\filters\AccessControl::className(),
                    'only' => ['create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['create', 'update', 'delete'],
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new LehrerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($L_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($L_ID),
        ]);
    }

    public function actionCreate()
    {
        $model = new Lehrer();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'L_ID' => $model->L_ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($L_ID)
    {
        $model = $this->findModel($L_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'L_ID' => $model->L_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($L_ID)
    {
        $this->findModel($L_ID)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($L_ID)
    {
        if (($model = Lehrer::findOne(['L_ID' => $L_ID])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}gi