<?php

namespace frontend\controllers;

use frontend\models\AmbulanceMaintenance;
use frontend\models\AmbulancemaintenanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * AmbulancemaintenanceController implements the CRUD actions for AmbulanceMaintenance model.
 */
class AmbulancemaintenanceController extends Controller
{
    public $layout = 'main_after_login';

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
     * Lists all AmbulanceMaintenance models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AmbulancemaintenanceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AmbulanceMaintenance model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AmbulanceMaintenance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AmbulanceMaintenance();

        if ($model->load(Yii::$app->request->post())) {
            Yii::debug('Waktu sebelum konversi: ' . $model->waktu); // Debug nilai sebelum konversi
            
            // Konversi datetime-local ke format yang sesuai
            $model->waktu = date('Y-m-d H:i:s', strtotime($model->waktu));
            
            Yii::debug('Waktu setelah konversi: ' . $model->waktu); // Debug nilai setelah konversi
            
            if ($model->validate() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AmbulanceMaintenance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AmbulanceMaintenance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AmbulanceMaintenance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AmbulanceMaintenance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AmbulanceMaintenance::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Checks for new AmbulanceMaintenance records.
     * @return \yii\web\Response
     */
    public function actionCheckNewMaintenances()
    {
        $newMaintenances = AmbulanceMaintenance::find()->where(['status' => 'new'])->count();
        return $this->asJson(['newMaintenances' => $newMaintenances]);
    }
}
