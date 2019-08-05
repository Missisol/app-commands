<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\board\GetInfoByBoard;
use frontend\modules\api\v1\models\board\CreateNewBoard;

class BoardController extends ApiController
{
    public function actionIndex()
    {
        $user_id = Yii::$app->user->identity->getId();
        return $this->getInfoByEntity(new GetInfoByBoard($user_id));
    }

    public function actionCreate()
    {
        $user_id = Yii::$app->user->identity->getId();
        return $this->doActionByEntity(new CreateNewBoard($user_id));
    }
}
