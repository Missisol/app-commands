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
        $model = new GetIssuesByIdListIssue();
        $model->setAttributes(Yii::$app->request->get());

        if ($result = $model->getIssues()) {
            return $this->sendResponse(self::STATUS_OK, $result);
        }
        
        return $this->sendResponse(self::STATUS_ERROR, $this->getMessage($model));
    }

    public function actionCreate()
    {
        return $this->createEntity(new CreateNewIssue());
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
