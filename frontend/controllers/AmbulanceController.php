<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Ambulance;
use frontend\models\AmbulanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use frontend\models\Reviews;

/**
 * AmbulanceController implements the CRUD actions for Ambulance model.
 */
class AmbulanceController extends Controller
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
     * Lists all Ambulance models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AmbulanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ambulance model.
     * @param int $id_ambulance ID Ambulance
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_ambulance)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_ambulance),
        ]);
    }

    /**
     * Creates a new Ambulance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Ambulance();

        if ($model->load(Yii::$app->request->post())) {
            $model->fotoFile = UploadedFile::getInstance($model, 'fotoFile');
            if ($model->fotoFile) {
                $img = uniqid('img-ambulance-' . date('YmdHis'), true);
                $model->img_url = '/upload/' . $img . '.' . $model->fotoFile->extension;
                $lokasi_simpan = 'upload/' . $img . '.' . $model->fotoFile->extension;
                if ($model->fotoFile->saveAs($lokasi_simpan)) {
                    $model->foto = $img . '.' . $model->fotoFile->extension; // Menambahkan nilai untuk kolom 'foto'
                    $model->save(false);
                    return $this->redirect(['view', 'id_ambulance' => $model->id_ambulance]);
                }
            } else {
                $model->save(false);
                return $this->redirect(['view', 'id_ambulance' => $model->id_ambulance]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionViewReviews($id_ambulance)
{
    // Temukan data ambulance berdasarkan ID
    $ambulance = Ambulance::findOne($id_ambulance);

    // Jika ambulance tidak ditemukan, lemparkan pengecualian
    if (!$ambulance) {
        throw new NotFoundHttpException('Ambulance tidak ditemukan.');
    }

    // Ambil semua review untuk ambulance ini
    $reviews = $ambulance->getReviews()->all();

    // Render tampilan dengan data ambulance dan review
    return $this->render('view-reviews', [
        'ambulance' => $ambulance,
        'reviews' => $reviews,
    ]);
}

    /**
     * Updates an existing Ambulance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_ambulance ID Ambulance
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_ambulance)
{
    $model = $this->findModel($id_ambulance);

    if ($model->load(Yii::$app->request->post())) {
        $model->fotoFile = UploadedFile::getInstance($model, 'fotoFile');

        if ($model->fotoFile) {
            $img = uniqid('img-ambulance-' . date('YmdHis'), true);
            $model->img_url = '/upload/' . $img . '.' . $model->fotoFile->extension;
            $lokasi_simpan = 'upload/' . $img . '.' . $model->fotoFile->extension;

            if ($model->fotoFile->saveAs($lokasi_simpan)) {
                $model->foto = $img . '.' . $model->fotoFile->extension;
            }
        }

        // Pastikan tipe disimpan dengan benar
        if ($model->save(false)) {
            return $this->redirect(['view', 'id_ambulance' => $model->id_ambulance]);
        }
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}

    /**
     * Deletes an existing Ambulance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_ambulance ID Ambulance
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_ambulance)
    {
        $this->findModel($id_ambulance)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ambulance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_ambulance ID Ambulance
     * @return Ambulance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_ambulance)
    {
        if (($model = Ambulance::findOne(['id_ambulance' => $id_ambulance])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
