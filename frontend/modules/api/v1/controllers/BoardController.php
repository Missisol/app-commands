<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\board\GetInfoByBoard;
use frontend\modules\api\v1\models\board\CreateNewBoard;
use frontend\modules\api\v1\models\board\UpdateBoard;

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
        return $this->createNewEntity(new CreateNewBoard($user_id));
    }

    public function actionUpdate($id)
    {
        return $this->doActionByEntity(new UpdateBoard($id));
    }
}
