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
        /*$model = new VerifyEmail();
        $model->setAttributes(Yii::$app->request->post());

        $user = $model->verifyEmail();
        if ($user && InitBoardUser::initBoard($user)) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));*/
    }

    public function actionAuth()
    {
        return $this->doActionByEntity(new AuthenticationUser());
        /*$model = new AuthenticationUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->login()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));*/
    }

    public function actionRecovery()
    {
        return $this->doActionByEntity(new RecoveryPasswordUser());
        /*$model = new RecoveryPasswordUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->recoveryPassword()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));*/
    }

    public function actionResetPassword()
    {
        return $this->doActionByEntity(new ResetPasswordUser());

        /*$model = new ResetPasswordUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->resetPassword()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));*/
    }

    public function actionUpdate()
    {
        $user = Yii::$app->user->identity;
        return $this->doActionByEntity(new ChangeDataUser($user));

        /*$model = new ChangeDataUser($user);
        $model->setAttributes(Yii::$app->request->post());

        if ($model->changeData()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));*/
    }

    public function actionChangePassword()
    {
        $user = Yii::$app->user->identity;
        return $this->doActionByEntity(new ChangePasswordUser($user));

        /*$model = new ChangePasswordUser($user);
        $model->setAttributes(Yii::$app->request->post());

        if ($model->changePassword()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));*/
    }

    public function actionChangeEmail()
    {
        $user = Yii::$app->user->identity;
        return $this->doActionByEntity(new ChangeEmailUser($user));

        /*$model = new ChangeEmailUser($user);
        $model->setAttributes(Yii::$app->request->post());

        if ($model->changeEmail()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));*/
    }

    public function actionVerifyNewEmail()
    {
        return $this->doActionByEntity(new VerifyNewEmail());
        /*$model = ;

        $model->setAttributes(Yii::$app->request->post());

        if ($model->verifyNewEmail()) {
            return $this->sendResponse(self::STATUS_OK);
        }*/
    }
}
