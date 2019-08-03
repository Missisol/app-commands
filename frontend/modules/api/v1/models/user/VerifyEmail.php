<?php

namespace frontend\modules\api\v1\models\user;

use common\models\User;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\service\InitBoardUser;
use frontend\modules\api\v1\models\ActionByEntity;

class VerifyEmail extends ValidationModel implements ActionByEntity
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
            $this->_user = User::findByVerificationToken($this->token);
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
        $user->status = User::STATUS_ACTIVE;

        //return $user->save(false) ? $user : null;
        if (!$user->save(false)) {
            return null;
        }

        return InitBoardUser::initBoard($user);
    }
}
