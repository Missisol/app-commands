<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\listIssue\CreateNewListIssue;

class ListIssueController extends ApiController
{
    public function actionCreate()
    {
        return $this->createEntity(new CreateNewListIssue());
    }
}
