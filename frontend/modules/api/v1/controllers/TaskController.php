<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\task\CreateNewTask;
use frontend\modules\api\v1\models\task\GetInfoByTask;
use frontend\modules\api\v1\models\task\UpdateTask;
use frontend\modules\api\v1\models\task\ChangePositionTask;

class TaskController extends ApiController
{
    public function actionCreate()
    {
        return $this->createNewEntity(new CreateNewTask());
    }

    public function actionIndex()
    {
        return $this->getInfoByEntity(new GetInfoByTask());
    }

    public function actionUpdate($id)
    {
        return $this->doActionByEntity(new UpdateTask($id));
    }

    public function actionChangePosition() {
        return $this->doActionByEntity(new ChangePositionTask());
    }
}
