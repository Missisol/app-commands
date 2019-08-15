<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\listUser\UpdateListUser;
use frontend\modules\api\v1\models\listUser\CreateNewListUser;

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
}
