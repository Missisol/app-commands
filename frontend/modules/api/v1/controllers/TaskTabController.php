<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\taskTab\GetColumnsByIdTaskTab;
use frontend\modules\api\v1\models\taskTab\CreateNewTaskTab;

class TaskTabController extends ApiController
{
    public function actionIndex()
    {
        return $this->getInfoByEntity(new GetColumnsByIdTaskTab(), true);
    }

    public function actionCreate()
    {
        return $this->doActionByEntity(new CreateNewTaskTab());
    }
}
