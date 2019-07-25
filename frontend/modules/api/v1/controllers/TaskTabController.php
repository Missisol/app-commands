<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\GetInfoByTaskTab;

class TaskTabController extends ApiController
{
    public function actionIndex($id)
    {
        $result = (new GetInfoByTaskTab($id))->getInfo();
        return $this->sendResponse(self::STATUS_OK, $result);
    }
}
