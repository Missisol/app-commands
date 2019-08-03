<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\columnList\CreateNewColumnList;

class ColumnListController extends ApiController
{
    public function actionCreate()
    {
        return $this->doActionByEntity(new CreateNewColumnList());
    }
}
