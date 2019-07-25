<?php

namespace frontend\modules\api\v1\models;

use common\models\User;

class ChangeDataUser extends ValidationModel
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

    public function changeData()
    {
        if (!$this->validate()) {
            return false;
        }

        if ($this->login)
            $this->user->login = $this->login;

        return $this->user->save();
    }
}
