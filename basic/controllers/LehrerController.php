<?php

namespace app\controllers;

use app\models\Lehrer;
use app\models\LehrerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LehrerController implements the CRUD actions for Lehrer model.
 */
class LehrerController extends Controller
{
    /**
     * @inheritDoc
     */
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
            ]
        );
    }

    /**
     * Lists all Lehrer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LehrerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lehrer model.
     * @param int $L_ID L ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($L_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($L_ID),
        ]);
    }

    /**
     * Creates a new Lehrer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
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

    /**
     * Updates an existing Lehrer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $L_ID L ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing Lehrer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $L_ID L ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($L_ID)
    {
        $this->findModel($L_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Lehrer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $L_ID L ID
     * @return Lehrer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($L_ID)
    {
        if (($model = Lehrer::findOne(['L_ID' => $L_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
