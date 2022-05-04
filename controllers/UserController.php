<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignUpForm;
use app\models\User;
use Yii;

class UserController extends \yii\web\Controller
{
    public function actionSignup()
    {

        if (Yii::$app->request->isPost) {
            $model = new SignupForm();
            $data = Yii::$app->request->post();
            if ($model->load($data)) {
                if ($user = $model->signup()) {
                    return $this->goHome();
                } else {
                    echo 'Не удалось создать пользователя';
                    die;
                }
            }
        }


        $model = new SignUpForm();
        return $this->render('signup', ['model' => $model]);
    }

    public function actionLogin()
    {
        // if (Yii::$app->request->isPost) {
        //     $dataPost = Yii::$app->request->post();
        //     $password = $dataPost['LoginForm']['password'];
        //     $userName = $dataPost['LoginForm']['username'];
        //     // var_dump($userName); die;
        //     $currentUser = User::findBylogin($userName);
        //     if(is_null($currentUser)){
        //         echo 'Нет такого пользователя!'; die;
        //     }
        //     if($currentUser->password == $password){
        //         echo 'Все хорошо пароль верный '; die;
        //     } else {
        //         echo 'Неправильный пароль'; die;
        //     }
        // }
        // $model = new LoginForm();
        // return $this->render('login', ['model' => $model]);

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {

        Yii::$app->user->logout();

        return $this->goHome();
    }
}
