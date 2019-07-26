<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\taskTab\GetInfoByTaskTab;
use frontend\modules\api\v1\models\taskTab\CreateNewTaskTab;

class TaskTabController extends ApiController
{
    public function actionIndex($id)
    {
        $result = (new GetInfoByTaskTab($id))->getInfo();
        return $this->sendResponse(self::STATUS_OK, $result);
    }

    public function actionCreate()
    {
        $model = new CreateNewTaskTab();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->create()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }
}
