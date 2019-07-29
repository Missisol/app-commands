<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\column\CreateNewColumn;

class ColumnController extends ApiController
{
    public function actionCreate()
    {
        return $this->createEntity(new CreateNewColumn());
    }
}
