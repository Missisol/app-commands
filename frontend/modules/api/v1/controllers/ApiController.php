<?php

namespace frontend\modules\api\v1\controllers;

use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;

abstract class ApiController extends Controller
{
    protected const MESSAGE_ERROR_SERVER = 'При выполнении операции на сервере возникли проблемы.';
    protected const STATUS_OK = 1;
    protected const STATUS_ERROR = 0;

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

    protected function sendResponse($status, $message = '')
    {
        return [
            'status' => $status,
            'payload' => [
                'message' => $message,
            ],
        ];
    }
}
