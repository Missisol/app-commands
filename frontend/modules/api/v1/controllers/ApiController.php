<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use frontend\modules\api\v1\models\CreateNewEntity;
use frontend\modules\api\v1\models\GetInfoByEntity;
use frontend\modules\api\v1\models\ValidationModel;

abstract class ApiController extends Controller
{
    protected const MESSAGE_ERROR_SERVER = 'При выполнении операции на сервере возникли проблемы.';
    protected const STATUS_OK = 1;
    protected const STATUS_ERROR = -1;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBearerAuth::class;
        return $behaviors;
    }

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    protected function sendResponse($status, $info = '')
    {
        if ($status == self::STATUS_OK) {
            return $info === '' ? [
                'status' => $status
            ] : [
                'status' => $status,
                'data' => $info
            ];
        }

        if ($status == self::STATUS_ERROR)
            return [
                'status' => $status,
                'message' => $info
            ];
    }

    /**
     * @param ValidationModel $model
     */
    protected function getMessage($model)
    {
        $errorValidation = $model->getErrorMessage();

        return $errorValidation ? $errorValidation : self::MESSAGE_ERROR_SERVER;
    }

    /**
     * @param CreateNewEntity $model
     */
    protected function createEntity($model) {
        $model->setAttributes(Yii::$app->request->post());

        if ($model->create()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    /**
     * @param GetInfoByEntity $model
     */
    protected function getInfoByEntity($model) {
        $result = $model->getInfo();
        return $this->sendResponse(self::STATUS_OK, $result);
    }
}
