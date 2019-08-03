<?php

namespace frontend\modules\api\v1\models\user;

use common\models\User;
use frontend\modules\api\v1\service\SendEmailUser;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class ChangeEmailUser extends ValidationModel implements ActionByEntity
{
    public $email;

    /**@var User */
    private $user;

    private const VIEW_NEW_EMAIL_VERIFICATION = 'newEmailVerify';
    private const SUBJECT_NEW_EMAIL_VERIFICATION = 'Confirm new email at ';

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
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email не может быть пустым.'],
            ['email', 'email', 'message' => 'Не валидный email адрес.'],
            ['email', 'string', 'max' => 255, 'tooLong' => 'Email может содержать максимум 255 символов.'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Данный email уже используется.'],
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->user->new_email = $this->email;
        $this->user->generateNewEmailVerificationToken();

        return $this->user->save() &&
            SendEmailUser::sendEmail(self::VIEW_NEW_EMAIL_VERIFICATION, $this->user, self::SUBJECT_NEW_EMAIL_VERIFICATION, $this->user->new_email);
    }
}
