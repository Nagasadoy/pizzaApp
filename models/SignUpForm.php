<?php

namespace app\models;

use app\models\User;
use DateTime;
use ErrorException;
use yii\base\Model;
use Yii;

class SignUpForm extends Model
{

    public $username;
    public $password;
    public $firstName;
    public $lastName;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'firstName', 'lastName'], 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
        ];
    }

    public function signup()
    {
        try {
            if (!$this->validate()) {
                return null;
            }
            $dt = new DateTime();

            // Создание нового пользователя
            // $user = new User();
            // $user->username = $this->username;
            // $user->setPassword($this->password);
            // $user->generateAuthKey();
            // $user->email = $this->email;
            // $user->last_name = $this->lastName;
            // $user->first_name = $this->firstName;
            // $user->second_name = $this->secondName;
            // $user->created_at = $dt->format('Y-m-d H:i:s');
            // $user->updated_at = $dt->format('Y-m-d H:i:s');
            // $user->role_id = $this->role_id;
            // $user->logpoint_id = $this->logpoint_id;
            $user = new User();
            $user->user_name = $this->username;
            $user->first_name = $this->firstName;
            $user->last_name = $this->lastName;
            $user->setPassword($this->password);
            return $user->save(false) ? $user : null;

        } catch (ErrorException $e) {
            return false;
        }
    }
}
