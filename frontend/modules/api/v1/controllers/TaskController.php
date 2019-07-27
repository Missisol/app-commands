<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\task\CreateNewTask;

class TaskController extends ApiController
{
    public function actionCreate()
    {
        return $this->createEntity(new CreateNewTask());
    }
}
