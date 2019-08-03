<?php

namespace frontend\modules\api\v1\models\user;

use common\models\User;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class ChangeDataUser extends ValidationModel implements ActionByEntity
{
    public $login;

    private $user;

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
            ['login', 'trim'],
            ['login', 'unique', 'targetClass' => User::class, 'message' => 'Данный логин уже используется.'],
            ['login', 'string', 'min' => 2, 'max' => 255, 'tooShort' => 'Логин должен содержать как минимум 2 символа.', 'tooLong' => 'Максимальная длина логина - 255 символов.'],
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->login)
            $this->user->login = $this->login;

        return $this->user->save();
    }
}
