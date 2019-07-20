<?php

namespace frontend\modules\api\v1\models;

use common\models\User;
use frontend\modules\api\v1\service\SendEmailUser;

class RecoveryPasswordUser extends ValidationModel
{
    public $email;

    /**
     * @var \common\models\User
     */
    private $_user;

    private const VIEW_EMAIL_RESET_PASSWORD = 'passwordResetToken';
    private const SUBJECT_EMAIL_RESET_PASSWORD = 'Password reset for ';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email не может быть пустым.'],
            ['email', 'email', 'message' => 'Не валидный email адрес.'],
            ['email', 'validateEmail'],
        ];
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'email' => $this->email,
            ]);
            if (!$this->_user) {
                $this->addError($attribute, 'Не найдено ни одного пользователя с таким email.');
            }
        }
    }

    public function recoveryPassword()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_user;
        if (!User::checkPasswordResetToken($user)) {
            return false;
        }

        return SendEmailUser::sendEmail(self::VIEW_EMAIL_RESET_PASSWORD, $user, self::SUBJECT_EMAIL_RESET_PASSWORD);
    }
}
