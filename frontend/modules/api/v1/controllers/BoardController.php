<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\GetInfoByBoard;

class BoardController extends ApiController
{
    public function actionIndex($id = null)
    {
        $user_id = Yii::$app->user->identity->getId();
        $result = (new GetInfoByBoard($user_id, $id))->getInfo();
        return $this->sendResponse(self::STATUS_OK, $result);
    }
}
