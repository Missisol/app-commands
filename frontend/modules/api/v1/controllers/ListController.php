<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\listUser\GetInfoByListUser;
use frontend\modules\api\v1\models\listUser\CreateNewListUser;

class ListController extends ApiController
{
    public function actionIndex($id)
    {
        return $this->getInfoByEntity(new GetInfoByListUser($id));
    }

    public function actionCreate()
    {
        return $this->createEntity(new CreateNewListUser());
    }
}
