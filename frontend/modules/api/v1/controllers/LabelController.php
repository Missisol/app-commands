<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\issue\GetIssuesByIdListIssue;
use frontend\modules\api\v1\models\issue\CreateNewIssue;
use frontend\modules\api\v1\models\issue\ChangeExecutionIssue;

class LabelController extends ApiController
{
    /*public function actionIndex()
    {
        return $this->getInfoByEntity(new GetIssuesByIdListIssue());
    }

    public function actionCreate()
    {
        return $this->doActionByEntity(new CreateNewIssue());
    }

    public function actionUpdate($id)
    {
        return $this->doActionByEntity(new ChangeExecutionIssue($id));
    }*/
}
