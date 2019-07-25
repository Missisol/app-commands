<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\InitViewBoard;

class BoardController extends ApiController
{
    public function actionIndex()
    {
        $user_id = Yii::$app->user->identity->getId();
        $result = (new InitViewBoard($user_id))->initView();
        return $this->sendResponse(self::STATUS_OK, $result);
    }
}
