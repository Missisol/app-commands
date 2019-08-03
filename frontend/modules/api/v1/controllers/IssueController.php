<?php

namespace frontend\modules\api\v1\controllers;

use Yii;
use frontend\modules\api\v1\models\issue\GetIssuesByIdListIssue;
use frontend\modules\api\v1\models\issue\CreateNewIssue;
use frontend\modules\api\v1\models\issue\ChangeExecutionIssue;

class IssueController extends ApiController
{
    public function actionIndex()
    {
        return $this->getInfoByEntity(new GetIssuesByIdListIssue(), true);
    }

    public function actionCreate()
    {
        return $this->doActionByEntity(new CreateNewIssue());
    }

    public function actionUpdate()
    {
        $model = new ChangeExecutionIssue();
        $model->setAttributes(Yii::$app->request->post());

        if ($model->changeExecution()) {
            return $this->sendResponse(self::STATUS_OK);
        }
        
        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }
}
