<?php

namespace frontend\controllers\api;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use frontend\models\Users; // Pastikan model Users sesuai dengan nama file dan namespace

class ApiAuthController extends Controller
{
    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        // Ambil data dari permintaan POST
        $data = Yii::$app->request->post();

        if (!isset($data['email'], $data['password'])) {
            return [
                "success" => false,
                "message" => "Incomplete data"
            ];
        }

        $email = $data['email'];
        $password = $data['password'];

        // Query untuk mendapatkan user
        $user = Users::findOne(['email' => $email]);

        if ($user) {
            // Verifikasi password
            if (Yii::$app->getSecurity()->validatePassword($password, $user->password)) {
                // Generate token (misalnya, menggunakan JWT atau random string)
                $token = Yii::$app->getSecurity()->generateRandomString(32); // Ganti dengan implementasi token yang sesuai

                // Anda bisa menyimpan token di database atau cache untuk verifikasi di masa mendatang

                return [
                    "success" => true,
                    "token" => $token,
                    "user" => [
                        "id" => $user->id,
                        "name" => $user->name,
                        "email" => $user->email,
                        "hp" => $user->hp,
                        "NIK" => $user->NIK,
                        "role" => $user->role,
                    ]
                ];
            } else {
                return ["success" => false, "message" => "Password salah"];
            }
        } else {
            return ["success" => false, "message" => "User tidak ditemukan"];
        }
    }

    public function actionLogout()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'message' => 'Logged out successfully'
        ];
    }

    public function actionRegister()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        // Ambil data dari permintaan POST
        $data = Yii::$app->request->post();

        if (!isset($data['email'], $data['password'], $data['name'])) {
            return [
                'success' => false,
                'message' => 'Incomplete data'
            ];
        }

        // Simpan user baru
        $user = new Users();
        $user->email = $data['email'];
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($data['password']); // Hash password
        $user->name = $data['name'];
        
        if ($user->save()) {
            return [
                'success' => true,
                'message' => 'User registered successfully',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Registration failed',
            ];
        }
    }
}
