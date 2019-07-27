<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\taskTab\GetInfoByTaskTab;
use frontend\modules\api\v1\models\taskTab\CreateNewTaskTab;

class TaskTabController extends ApiController
{
    public function actionIndex($id)
    {
        return $this->getInfoByEntity(new GetInfoByTaskTab($id));
    }

    public function actionCreate()
    {
        return $this->createEntity(new CreateNewTaskTab());
    }
}
