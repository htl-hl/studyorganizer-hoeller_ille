<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSearch;
use app\models\Lehrer;
use app\models\LehrerSearch;
use app\models\Faecher;
use app\models\FaecherSearch;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class AdminController extends Controller
{
    public $layout = 'Admin';

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete'         => ['POST'],
                        'toggle-admin'   => ['POST'],
                        'Lehrer-delete'  => ['POST'],
                        'Faecher-delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    protected function requireAdmin()
    {
        $identity = Yii::$app->user->identity;
        if ($identity === null || !$identity->isAdmin()) {
            throw new ForbiddenHttpException('Nur Admins haben Zugriff auf diesen Bereich.');
        }
    }

    // =========================================================
    // SCHUELER / USER
    // =========================================================

    public function actionIndex()
    {
        $this->requireAdmin();

        $searchModel  = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $totalUsers  = User::find()->count();
        $adminCount  = User::find()->where(['is_admin' => 1])->count();
        $normalCount = $totalUsers - $adminCount;

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'totalUsers'   => $totalUsers,
            'adminCount'   => $adminCount,
            'normalCount'  => $normalCount,
        ]);
    }

    public function actionView($U_ID)
    {
        $this->requireAdmin();
        return $this->render('view', [
            'model' => $this->findModel($U_ID),
        ]);
    }

    public function actionCreate()
    {
        $this->requireAdmin();
        $model = new User();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if (!empty($model->Pwd)) {
                    $model->Pwd = Yii::$app->security->generatePasswordHash($model->Pwd);
                }
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'User wurde erfolgreich erstellt.');
                    return $this->redirect(['view', 'U_ID' => $model->U_ID]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($U_ID)
    {
        $this->requireAdmin();
        $model    = $this->findModel($U_ID);
        $savedPwd = $model->Pwd;

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if (empty($model->Pwd)) {
                $model->Pwd = $savedPwd;
            } else {
                $model->Pwd = Yii::$app->security->generatePasswordHash($model->Pwd);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'User wurde aktualisiert.');
                return $this->redirect(['view', 'U_ID' => $model->U_ID]);
            }
        }

        $model->Pwd = '';
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($U_ID)
    {
        $this->requireAdmin();

        if ((int)$U_ID === (int)Yii::$app->user->id) {
            Yii::$app->session->setFlash('danger', 'Du kannst deinen eigenen Account nicht loeschen.');
            return $this->redirect(['index']);
        }

        $this->findModel($U_ID)->delete();
        Yii::$app->session->setFlash('success', 'User wurde geloescht.');
        return $this->redirect(['index']);
    }

    public function actionToggleAdmin($U_ID)
    {
        $this->requireAdmin();

        if ((int)$U_ID === (int)Yii::$app->user->id) {
            Yii::$app->session->setFlash('danger', 'Du kannst deinen eigenen Admin-Status nicht aendern.');
            return $this->redirect(['index']);
        }

        $model = $this->findModel($U_ID);
        if ($model->is_admin == 1) {
            $model->is_admin = 0;
            $msg = 'Admin-Rechte wurden entzogen.';
        } else {
            $model->is_admin = 1;
            $msg = 'User wurde zum Admin ernannt.';
        }

        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', $msg);
        }

        return $this->redirect(['index']);
    }

    protected function findModel($U_ID)
    {
        $model = User::findOne(['U_ID' => $U_ID]);
        if ($model !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Der angeforderte User wurde nicht gefunden.');
    }

    // =========================================================
    // LEHRER
    // =========================================================

    public function actionLehrer()
    {
        $this->requireAdmin();

        $searchModel  = new LehrerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('Lehrer', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLehrerCreate()
    {
        $this->requireAdmin();
        $model = new Lehrer();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Lehrer wurde erstellt.');
            return $this->redirect(['Lehrer']);
        }

        return $this->render('Lehrer-form', ['model' => $model]);
    }

    public function actionLehrerUpdate($L_ID)
    {
        $this->requireAdmin();
        $model = $this->findLehrer($L_ID);

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Lehrer wurde aktualisiert.');
            return $this->redirect(['Lehrer']);
        }

        return $this->render('Lehrer-form', ['model' => $model]);
    }

    public function actionLehrerDelete($L_ID)
    {
        $this->requireAdmin();
        $this->findLehrer($L_ID)->delete();
        Yii::$app->session->setFlash('success', 'Lehrer wurde geloescht.');
        return $this->redirect(['Lehrer']);
    }

    protected function findLehrer($L_ID)
    {
        $model = Lehrer::findOne(['L_ID' => $L_ID]);
        if ($model !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Der angeforderte Lehrer wurde nicht gefunden.');
    }

    // =========================================================
    // FAECHER
    // =========================================================

    public function actionFaecher()
    {
        $this->requireAdmin();

        $searchModel  = new FaecherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('Faecher', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFaecherCreate()
    {
        $this->requireAdmin();
        $model = new Faecher();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Fach wurde erstellt.');
            return $this->redirect(['Faecher']);
        }

        return $this->render('Faecher-form', ['model' => $model]);
    }

    public function actionFaecherUpdate($F_Name)
    {
        $this->requireAdmin();
        $model = $this->findFach($F_Name);

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Fach wurde aktualisiert.');
            return $this->redirect(['Faecher']);
        }

        return $this->render('Faecher-form', ['model' => $model]);
    }

    public function actionFaecherDelete($F_Name)
    {
        $this->requireAdmin();
        $this->findFach($F_Name)->delete();
        Yii::$app->session->setFlash('success', 'Fach wurde geloescht.');
        return $this->redirect(['Faecher']);
    }

    protected function findFach($F_Name)
    {
        $model = Faecher::findOne(['F_Name' => $F_Name]);
        if ($model !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Das angeforderte Fach wurde nicht gefunden.');
    }
}