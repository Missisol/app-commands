<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\CreateNewTask;

class TaskController extends ApiController
{
    public function actionCreate()
    {
        $model = new CreateNewTask();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->create()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }
}
