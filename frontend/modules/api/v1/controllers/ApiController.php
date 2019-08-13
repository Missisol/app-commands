<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use frontend\modules\api\v1\models\GetInfoByEntity;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;
use frontend\modules\api\v1\models\DeleteEntity;
use frontend\modules\api\v1\models\CreateNewEntity;
use yii\filters\Cors;

abstract class ApiController extends Controller
{
    protected const MESSAGE_ERROR_SERVER = 'При выполнении операции на сервере возникли проблемы.';
    protected const STATUS_OK = 1;
    protected const STATUS_ERROR = -1;

    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter']['class'] = Cors::class;
        $behaviors['corsFilter']['cors'] = [
            'Origin' => ['*'],
            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            'Access-Control-Request-Headers' => ['*'],
        ];

        unset($behaviors['authenticator']);
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
        if (self::STATUS_OK == $status) {
            return '' === $info ? [
                'status' => $status,
            ] : [
                'status' => $status,
                'data' => $info,
            ];
        }

        if (self::STATUS_ERROR == $status) {
            return [
                'status' => $status,
                'message' => $info,
            ];
        }
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
     * @param GetInfoByEntity $model
     */
    protected function getInfoByEntity($model)
    {
        $model->setAttributes(Yii::$app->request->get());

        if ($result = $model->getInfo()) {
            return $this->sendResponse(self::STATUS_OK, $result);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    /**
     * @param ActionByEntity $model
     */
    protected function doActionByEntity($model)
    {
        $model->setAttributes(Yii::$app->request->post());

        if ($model->doAction()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

     /**
     * @param CreateNewEntity $model
     */
    protected function createNewEntity($model)
    {
        $model->setAttributes(Yii::$app->request->post());

        if ($result = $model->create()) {
            return $this->sendResponse(self::STATUS_OK, $result);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    /**
     * @param DeleteEntity $model
     */
    protected function deleteEntity($model)
    {
        if ($model->delete()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }
}
