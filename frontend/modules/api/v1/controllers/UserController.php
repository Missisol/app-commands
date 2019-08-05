<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\user\RegistrationUser;
use frontend\modules\api\v1\models\user\VerifyEmail;
use frontend\modules\api\v1\models\user\AuthenticationUser;
use frontend\modules\api\v1\models\user\RecoveryPasswordUser;
use frontend\modules\api\v1\models\user\ResetPasswordUser;
use common\models\User;
use frontend\modules\api\v1\models\user\ChangeDataUser;
use frontend\modules\api\v1\models\user\ChangePasswordUser;
use frontend\modules\api\v1\models\user\ChangeEmailUser;
use frontend\modules\api\v1\models\user\VerifyNewEmail;

class UserController extends ApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['only'] = [
            'index',
            'update',
            'change-password',
            'change-email',
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $user->setScenario(User::SCENARIO_PROFILE);

        return $this->sendResponse(self::STATUS_OK, $user);
    }

    public function actionCreate()
    {
        return $this->doActionByEntity(new RegistrationUser());
    }

    public function actionVerifyEmail()
    {
        return $this->doActionByEntity(new VerifyEmail());
    }

    public function actionAuth()
    {
        return $this->doActionByEntity(new AuthenticationUser());
    }

    public function actionRecovery()
    {
        return $this->doActionByEntity(new RecoveryPasswordUser());
    }

    public function actionResetPassword()
    {
        return $this->doActionByEntity(new ResetPasswordUser());
    }

    public function actionUpdate()
    {
        $user = Yii::$app->user->identity;

        return $this->doActionByEntity(new ChangeDataUser($user));
    }

    public function actionChangePassword()
    {
        $user = Yii::$app->user->identity;

        return $this->doActionByEntity(new ChangePasswordUser($user));
    }

    public function actionChangeEmail()
    {
        $user = Yii::$app->user->identity;

        return $this->doActionByEntity(new ChangeEmailUser($user));
    }

    public function actionVerifyNewEmail()
    {
        return $this->doActionByEntity(new VerifyNewEmail());
    }
}
