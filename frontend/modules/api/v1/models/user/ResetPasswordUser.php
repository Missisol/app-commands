<?php

namespace frontend\modules\api\v1\models\user;

use common\models\User;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class ResetPasswordUser extends ValidationModel implements ActionByEntity
{
    public $password;
    public $token;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required', 'message' => 'Пароль не может быть пустым.'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать как минимум 6 символов.'],

            ['token', 'required', 'message' => 'Токен не может быть пустым.'],
            ['token', 'validateToken'],
        ];
    }

    public function validateToken($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = User::findByPasswordResetToken($this->token);
            if (!$this->_user) {
                $this->addError($attribute, 'Неверный токен.');
            }
        }
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
