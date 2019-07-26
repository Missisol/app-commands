<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\column\CreateNewColumn;

class ColumnController extends ApiController
{
    public function actionCreate()
    {
        $model = new CreateNewColumn();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->create()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }
}
