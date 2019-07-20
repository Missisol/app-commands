<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\RegistrationUser;
use frontend\modules\api\v1\models\VerifyEmail;
use frontend\modules\api\v1\models\AuthenticationUser;
use frontend\modules\api\v1\models\RecoveryPasswordUser;
use frontend\modules\api\v1\models\ResetPasswordUser;
use common\models\User;
use frontend\modules\api\v1\service\InitBoardUser;

class UserController extends ApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['only'] = ['index', 'update'];

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
        $model = new RegistrationUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->signup()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionVerifyEmail()
    {
        $model = new VerifyEmail();
        $model->setAttributes(Yii::$app->request->post());

        $user = $model->verifyEmail();
        if ($user && InitBoardUser::initBoard($user)) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionAuth()
    {
        $model = new AuthenticationUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->login()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionRecovery()
    {
        $model = new RecoveryPasswordUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->recoveryPassword()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionResetPassword()
    {
        $model = new ResetPasswordUser();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->resetPassword()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    private function getMessage($model)
    {
        $errorValidation = $model->getErrorMessage();

        return $errorValidation ? $errorValidation : self::MESSAGE_ERROR_SERVER;
    }
}
