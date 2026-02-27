<?php

namespace app\controllers;

use app\models\Faecher;
use app\models\Hausaufgaben;
use app\models\HausaufgabenSearch;
use app\models\Lehrer;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HausaufgabenController implements the CRUD actions for Hausaufgaben model.
 */
class HausaufgabenController extends Controller
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
     * Lists all Hausaufgaben models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new HausaufgabenSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Hausaufgaben model.
     * @param int $HU_ID Hu ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($HU_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($HU_ID),
        ]);
    }

    /**
     * Creates a new Hausaufgaben model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $hausaufgaben = Hausaufgaben::find()->all();
        $model = new Hausaufgaben();
        $lehrer = Lehrer::find()->all();
        $user = User::find()->all();
        $faecher = Faecher::find()->all();

        foreach ($lehrer as $le) {
            $array[$le->L_ID] = $le->Nachname;
        }

        foreach ($user as $u) {
            $arrayUser[$u->U_ID] = $u->Name;
        }

        $dropdownLehrer = ArrayHelper::map($lehrer, 'L_ID', 'Nachname');
        $dropdownUser = ArrayHelper::map($user, 'U_ID', 'Name');
        $dropdownFaecher = ArrayHelper::map($faecher, 'F_Name', 'F_Name');


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'HU_ID' => $model->HU_ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'dropdownLehrer' => $dropdownLehrer,
            'dropdownUser' => $dropdownUser,
            'dropdownFaecher' => $dropdownFaecher,
            'hausaufgaben' => $hausaufgaben,
        ]);
    }

    /**
     * Updates an existing Hausaufgaben model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $HU_ID Hu ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($HU_ID)
    {
        $model = $this->findModel($HU_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'HU_ID' => $model->HU_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Hausaufgaben model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $HU_ID Hu ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($HU_ID)
    {
        $this->findModel($HU_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Hausaufgaben model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $HU_ID Hu ID
     * @return Hausaufgaben the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($HU_ID)
    {
        if (($model = Hausaufgaben::findOne(['HU_ID' => $HU_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
