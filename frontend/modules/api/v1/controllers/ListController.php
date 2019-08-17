<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\listUser\ChangePositionListUser;
use frontend\modules\api\v1\models\listUser\UpdateListUser;
use frontend\modules\api\v1\models\listUser\CreateNewListUser;
use frontend\modules\api\v1\models\listUser\GetInfoByListUser;

class ListController extends ApiController
{
    public function actionUpdate($id)
    {
        return $this->doActionByEntity(new UpdateListUser($id));
    }

    public function actionCreate()
    {
        return $this->createNewEntity(new CreateNewListUser());
    }

    public function actionChangePosition() {
        return $this->doActionByEntity(new ChangePositionListUser());
    }

    public function actionIndex() {
        return $this->getInfoByEntity(new GetInfoByListUser());
    }
}
