<?php

namespace app\controllers;

use app\models\Faecher;
use app\models\FaecherSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FaecherController implements the CRUD actions for Faecher model.
 */
class FaecherController extends Controller
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
     * Lists all Faecher models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FaecherSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Faecher model.
     * @param string $F_Name F Name
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($F_Name)
    {
        return $this->render('view', [
            'model' => $this->findModel($F_Name),
        ]);
    }

    /**
     * Creates a new Faecher model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Faecher();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'F_Name' => $model->F_Name]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Faecher model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $F_Name F Name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($F_Name)
    {
        $model = $this->findModel($F_Name);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'F_Name' => $model->F_Name]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Faecher model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $F_Name F Name
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($F_Name)
    {
        $this->findModel($F_Name)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Faecher model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $F_Name F Name
     * @return Faecher the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($F_Name)
    {
        if (($model = Faecher::findOne(['F_Name' => $F_Name])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
