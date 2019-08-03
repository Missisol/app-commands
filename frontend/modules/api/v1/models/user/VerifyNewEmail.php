<?php

namespace frontend\modules\api\v1\models\user;

use common\models\User;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class VerifyNewEmail extends ValidationModel implements ActionByEntity
{
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
            ['token', 'required', 'message' => 'Токен не может быть пустым.'],
            ['token', 'validateToken'],
        ];
    }

    public function validateToken($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_user = User::findByVerifyNewEmailToken($this->token);
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
        $user->email = $user->new_email;
        $user->new_email = null;
        $user->verify_new_email_token = null;
        return $user->save(false);
    }
}
