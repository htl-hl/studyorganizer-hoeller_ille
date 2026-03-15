<?php

namespace app\controllers;

use app\models\Faecher;
use app\models\FaecherSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FaecherController implements the CRUD actions for Faecher model.
 */
class FaecherController extends Controller
{
    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
            $this->layout = 'Admin';
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
                            'matchCallback' => function ($rule, $action) {
                                return Yii::$app->user->identity->isAdmin();
                            }
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $model = new Faecher();
        $searchModel = new FaecherSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'model'        => $model,
        ]);
    }

    public function actionView($F_Name)
    {
        return $this->render('view', [
            'model' => $this->findModel($F_Name),
        ]);
    }

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

    public function actionDelete($F_Name)
    {
        $this->findModel($F_Name)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($F_Name)
    {
        if (($model = Faecher::findOne(['F_Name' => $F_Name])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}