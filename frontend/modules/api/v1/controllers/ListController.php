<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\GetInfoByListUser;

class ListController extends ApiController
{
    public function actionIndex($id)
    {
        $result = (new GetInfoByListUser($id))->getInfo();
        return $this->sendResponse(self::STATUS_OK, $result);
    }
}
