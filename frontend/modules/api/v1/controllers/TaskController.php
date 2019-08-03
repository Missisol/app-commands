<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\task\CreateNewTask;
use frontend\modules\api\v1\models\task\GetTasksByIdTask;

class TaskController extends ApiController
{
    public function actionCreate()
    {
        return $this->createEntity(new CreateNewTask());
    }

    public function actionIndex() {
        return $this->getInfoByEntity(new GetTasksByIdTask(), true);
    }
}
