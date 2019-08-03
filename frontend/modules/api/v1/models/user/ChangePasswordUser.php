<?php

namespace frontend\modules\api\v1\models\user;

use common\models\User;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class ChangePasswordUser extends ValidationModel implements ActionByEntity
{
    public $old_password;
    public $new_password;

    /*@var User */
    private $user;

    /**
     * @param User $user
     */
    public function __construct($user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['old_password', 'required', 'message' => 'Старый пароль не может быть пустым.'],
            ['old_password', 'validateOldPassword'],

            ['new_password', 'required', 'message' => 'Новый пароль не может быть пустым.'],
            ['new_password', 'string', 'min' => 6, 'tooShort' => 'Новый пароль должен содержать как минимум 6 символов.'],
        ];
    }

    public function validateOldPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->user->validatePassword($this->old_password)) {
                $this->addError($attribute, 'Некорректный старый пароль.');
            }
        }
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->user->setPassword($this->new_password);
        return $this->user->save();
    }
}
