<?php

namespace frontend\controllers;

use frontend\models\Orders;
use frontend\models\OrdersSearch;
use frontend\models\Ambulance;
use frontend\models\Drivers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param string $kode_order Kode Order
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($kode_order)
    {
        return $this->render('view', [
            'model' => $this->findModel($kode_order),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'kode_order' => $model->kode_order]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $kode_order Kode Order
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($kode_order)
    {
        $model = $this->findModel($kode_order);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'kode_order' => $model->kode_order]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $kode_order Kode Order
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($kode_order)
    {
        $this->findModel($kode_order)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Accepts an existing Orders model and redirects to driver and ambulance selection.
     * @param string $kode_order Kode Order
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
public function actionAccept($kode_order)
{
    $model = $this->findModel($kode_order);

    // Ambil data dari request
    $postData = $this->request->post('Orders', []);

    // Ambil daftar ambulance dan sopir dari database atau sumber lainnya
    $ambulanceList = ArrayHelper::map(
        Ambulance::find()->where(['status' => 0])->all(), 'id_ambulance', 'nama'
    );
    $driverList = ArrayHelper::map(Drivers::find()->all(), 'id', 'nama');

    if (isset($postData['id_ambulans']) && isset($postData['id_sopir'])) {
        $model->id_ambulans = $postData['id_ambulans'];
        $model->id_sopir = $postData['id_sopir'];
        $model->status = 'Diterima'; // Gunakan salah satu nilai enum yang valid

        if ($model->save()) {
            // Tambahkan notifikasi ke tabel notifications_mobile dan notifications_driver
            $conn = Yii::$app->db;

            // Data notifikasi
            $user_id = $model->id_pemesan;
            $id_sopir = $model->id_sopir;
            $pesan = "Order dengan kode $kode_order telah diterima oleh sopir dengan ID $id_sopir.";
            $pesan2 = "Anda mendapatkan tugas penjemputan pasien dengan ambulans dengan kode pemesanan $kode_order.";
            $status = 'unread';
            $status2 = 'unread';

            // Tambahkan notifikasi ke notifications_mobile
            $sql_insert = "INSERT INTO notifications_mobile (user_id, pesan, status, order_status) VALUES (:user_id, :pesan, :status, :order_status)";
            $conn->createCommand($sql_insert)
                ->bindValue(':user_id', $user_id)
                ->bindValue(':pesan', $pesan)
                ->bindValue(':status', $status)
                ->bindValue(':order_status', 'Diterima')
                ->execute();

            // Tambahkan notifikasi ke notifications_driver
            $sql_insert2 = "INSERT INTO notifications_driver (user_id, pesan, status) VALUES (:user_id, :pesan, :status)";
            $conn->createCommand($sql_insert2)
                ->bindValue(':user_id', $id_sopir)
                ->bindValue(':pesan', $pesan2)
                ->bindValue(':status', $status2)
                ->execute();

            // Redirect ke tampilan dengan pesan sukses
            Yii::$app->session->setFlash('success', 'Order berhasil diterima dan notifikasi telah dikirim.');
            return $this->redirect(['view', 'kode_order' => $model->kode_order]);
        } else {
            Yii::error('Gagal menyimpan model pesanan: ' . json_encode($model->errors), __METHOD__);
        }
    } else {
        Yii::warning('Data tidak lengkap untuk pemrosesan: ' . json_encode($postData), __METHOD__);
    }

    // Kembali ke tampilan dengan data
    return $this->render('accept', [
        'model' => $model,
        'ambulanceList' => $ambulanceList, // Kirimkan ke view
        'driverList' => $driverList,       // Kirimkan ke view
    ]);
}



    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $kode_order Kode Order
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kode_order)
    {
        if (($model = Orders::findOne(['kode_order' => $kode_order])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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
}
