<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\task\CreateNewTask;
use frontend\modules\api\v1\models\task\GetTasksByIdTask;
use frontend\modules\api\v1\models\task\UpdateTask;

class TaskController extends ApiController
{
    public function actionCreate()
    {
        return $this->doActionByEntity(new CreateNewTask());
    }

    public function actionIndex()
    {
        return $this->getInfoByEntity(new GetTasksByIdTask());
    }

    public function actionUpdate($id)
    {
        return $this->doActionByEntity(new UpdateTask($id));
    }
}
