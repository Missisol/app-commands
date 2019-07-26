<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\GetInfoByBoard;
use frontend\modules\api\v1\models\CreateNewBoard;

class BoardController extends ApiController
{
    public function actionIndex($id = null)
    {
        $user_id = Yii::$app->user->identity->getId();
        $result = (new GetInfoByBoard($user_id, $id))->getInfo();
        return $this->sendResponse(self::STATUS_OK, $result);
    }

    public function actionCreate()
    {
        $user_id = Yii::$app->user->identity->getId();
        $model = new CreateNewBoard($user_id);
        $model->setAttributes(Yii::$app->request->post());

        if ($model->create()) {
            return $this->sendResponse(self::STATUS_OK);
        }

        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }
}
