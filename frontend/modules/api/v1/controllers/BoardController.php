<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\board\GetInfoByBoard;
use frontend\modules\api\v1\models\board\CreateNewBoard;

class BoardController extends ApiController
{
    public function actionIndex($id = null)
    {
        $user_id = Yii::$app->user->identity->getId();
        return $this->getInfoByEntity(new GetInfoByBoard($user_id, $id));
    }

    public function actionCreate()
    {
        $user_id = Yii::$app->user->identity->getId();
        return $this->createEntity(new CreateNewBoard($user_id));
    }
}
