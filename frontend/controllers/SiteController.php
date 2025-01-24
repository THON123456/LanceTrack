<?php

namespace frontend\controllers;

use frontend\models\VerifyEmailForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\AmbulanceBooking;
use frontend\models\Ambulance;
use frontend\models\AmbulanceLocation;
use frontend\models\AmbulanceMaintenance;
use frontend\models\AmbulanceShift;
use frontend\models\AmbulanceUlasan;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Notification;
use frontend\models\Orders; // Update model reference
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    public $layout = 'main_after_login';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'request-password-reset', 'reset-password', 'verify-email', 'resend-verification-email'],
                'rules' => [
                    [
                        'actions' => ['signup', 'request-password-reset', 'reset-password', 'verify-email', 'resend-verification-email'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['site/login']);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'main_before_login';
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/dashboard']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays dashboard page.
     *
     * @return mixed
     */
    public function actionDashboard()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Orders::find()->where(['status' => 'Pending'])->with('ambulance'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $jumlahPemesan = Orders::find()->count();
        $jumlahAmbulanceReady = Ambulance::find()->where(['status' => '0'])->count();
        $jumlahAmbulanceRusak = Ambulance::find()->where(['status' => '1'])->count();


        return $this->render('dashboard', [
            'dataProvider' => $dataProvider,
            'jumlahPemesan' => $jumlahPemesan,
            'jumlahAmbulanceReady' => $jumlahAmbulanceReady,
            'jumlahAmbulanceRusak' => $jumlahAmbulanceRusak,
        ]);
    }

    public function actionCreate()
    {
        $model = new Orders();
        $model->status = 'Menunggu Konfirmasi'; 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['dashboard']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionAccept($kode_order)
    {
        $model = $this->findModel($kode_order);
        $model->status = 'Diterima';
        if ($model->save()) {
            return $this->redirect(['dashboard']);
        }
    }

    public function actionReject($kode_order)
    {
        $model = $this->findModel($kode_order);
        $model->delete();
        return $this->redirect(['dashboard']);
    }

    protected function findModel($kode_order)
    {
        if (($model = Orders::findOne(['kode_order' => $kode_order])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $this->layout = Yii::$app->user->isGuest ? 'main_before_login' : 'main_after_login';
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $this->layout = Yii::$app->user->isGuest ? 'main_before_login' : 'main_after_login';
        return $this->render('about');
    }

    public function actionCheckNew()
{
    $newNotificationsCount = Notification::find()->where(['user_id' => Yii::$app->user->id, 'is_read' => 0])->count();
    return $this->asJson(['newNotificationsCount' => $newNotificationsCount]);
}
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
{
    $this->layout = 'main_before_login';
    $model = new SignupForm();
    if ($model->load(Yii::$app->request->post()) && $model->signup()) {
        Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
        return $this->goHome();
    }

    return $this->render('signup', [
        'model' => $model,
    ]);
}


    public function sendEmail()
{
    /* @var $user User */
    $user = User::findOne([
        'status' => User::STATUS_ACTIVE,
        'email' => $this->email,
    ]);

    if (!$user) {
        return false;
    }

    if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
        $user->generatePasswordResetToken();
        if (!$user->save()) {
            return false;
        }
    }
    

    return Yii::$app->mailer->compose(
            ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
            ['user' => $user]
        )
        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
        ->setTo($this->email)
        ->setSubject('Password reset for ' . Yii::$app->name)
        ->send();
}


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'main_before_login';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'main_before_login';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        $this->layout = 'main_before_login';
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we were unable to verify your email address.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $this->layout = 'main_before_login';
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->sendEmail()) {
            Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        return $this->render('resendVerificationEmail', [
            'model' => $model,
        ]);
    }

    public function actionNotification()
{
    $notifications = Notification::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC])->all();
    return $this->renderPartial('_notification-dropdown', ['notifications' => $notifications]);
}

    public function actionAccount()
{
    $userId = Yii::$app->user->id;
    $user = User::findOne($userId);

    if ($user === null) {
        throw new \yii\web\NotFoundHttpException('User not found.');
    }

    return $this->render('account', [
        'user' => $user,
    ]);
}

}
