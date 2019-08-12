<?php

namespace frontend\modules\api\v1\models\user;

use common\models\User;
use frontend\modules\api\v1\service\SendEmailUser;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;
use frontend\modules\api\v1\service\InitBoardUser;

class RegistrationUser extends ValidationModel implements ActionByEntity
{
    public $login;
    public $email;
    public $password;

    private const VIEW_EMAIL_REGISTRATION = 'emailVerify';
    private const SUBJECT_EMAIL_REGISTRATION = 'Account registration at ';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['login', 'trim'],
            ['login', 'required', 'message' => 'Логин не может быть пустым.'],
            ['login', 'unique', 'targetClass' => User::class, 'message' => 'Данный логин уже используется.'],
            ['login', 'string', 'min' => 2, 'max' => 255, 'tooShort' => 'Логин должен содержать как минимум 2 символа.', 'tooLong' => 'Максимальная длина логина - 255 символов.'],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email не может быть пустым.'],
            ['email', 'email', 'message' => 'Не валидный email адрес.'],
            ['email', 'string', 'max' => 255, 'tooLong' => 'Email может содержать максимум 255 символов.'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Данный email уже используется.'],

            ['password', 'required', 'message' => 'Пароль не может быть пустым.'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать как минимум 6 символов.'],
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->login = $this->login;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->generateAccessToken();
        $user->status = User::STATUS_ACTIVE;

        return $user->save() && 
            SendEmailUser::sendEmail(self::VIEW_EMAIL_REGISTRATION, $user, self::SUBJECT_EMAIL_REGISTRATION) &&
            InitBoardUser::initBoard($user);//временно - до внедрения подтверждения эл почты
    }
}
