<?php

namespace frontend\controllers;

use frontend\models\AmbulanceShift;
use frontend\models\Pegawai;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * AmbulanceshiftController implements the CRUD actions for AmbulanceShift model.
 */
class AmbulanceshiftController extends Controller
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
     * Lists all AmbulanceShift models.
     *
     * @return string
     */
    public function actionIndex()
{
    $dataProvider = new ActiveDataProvider([
        'query' => AmbulanceShift::find()->with('pegawai'),
    ]);

    // Ambil data pegawai untuk ditampilkan dalam shift
    $pegawaiProvider = new ActiveDataProvider([
        'query' => Pegawai::find()->joinWith('jabatan'),
    ]);

    // Ambil staf berdasarkan jabatan untuk shift hari ini
    $staffPerShift = [
        'sopir' => Pegawai::find()->joinWith('jabatan')->where(['jabatan.jabatan' => 'Sopir'])->all(),
        'dokter' => Pegawai::find()->joinWith('jabatan')->where(['jabatan.jabatan' => 'Dokter'])->all(),
        'perawat' => Pegawai::find()->joinWith('jabatan')->where(['jabatan.jabatan' => 'Perawat'])->all(),
    ];

    // Menghitung waktu shift saat ini
    $currentTime = time();
    $shiftDuration = 12 * 60 * 60; // 12 jam dalam detik
    $shiftStartTime = floor($currentTime / $shiftDuration) * $shiftDuration;
    $shiftEndTime = $shiftStartTime + $shiftDuration;

    // Menghitung offset berdasarkan waktu saat ini dan durasi shift
    $shiftOffset = floor($currentTime / $shiftDuration);

    // Menghindari pembagian dengan nol
    $totalSopir = count($staffPerShift['sopir']);
    $totalDokter = count($staffPerShift['dokter']);
    $totalPerawat = count($staffPerShift['perawat']);

    $staffToday = [
        'sopir' => $totalSopir > 0 ? $staffPerShift['sopir'][$shiftOffset % $totalSopir] : null,
        'dokter' => $totalDokter > 0 ? $staffPerShift['dokter'][$shiftOffset % $totalDokter] : null,
        'perawat' => $totalPerawat > 0 ? array_slice($staffPerShift['perawat'], $shiftOffset % $totalPerawat, 2) : [],
    ];

    return $this->render('index', [
        'dataProvider' => $dataProvider,
        'pegawaiProvider' => $pegawaiProvider,
        'staffToday' => $staffToday,
        'shiftStartTime' => $shiftStartTime,
        'shiftEndTime' => $shiftEndTime,
    ]);
}



    /**
     * Displays a single AmbulanceShift model.
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
     * Creates a new AmbulanceShift model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AmbulanceShift();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AmbulanceShift model.
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
     * Deletes an existing AmbulanceShift model.
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
     * Check for new shifts.
     * @return \yii\web\Response
     */
    public function actionCheckNewShifts()
    {
        $newShifts = AmbulanceShift::find()->where(['status' => 'new'])->count();
        return $this->asJson(['newShifts' => $newShifts]);
    }

    /**
     * Finds the AmbulanceShift model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AmbulanceShift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AmbulanceShift::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
