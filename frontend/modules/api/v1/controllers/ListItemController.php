<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\listItem\CreateNewListItem;
use frontend\modules\api\v1\models\listItem\UpdateListItem;
use frontend\modules\api\v1\models\listItem\ChangePositionListItem;

class ListItemController extends ApiController
{
    public function actionCreate()
    {
        return $this->createNewEntity(new CreateNewListItem());
    }

    public function actionUpdate($id)
    {
        return $this->doActionByEntity(new UpdateListItem($id));
    }

    public function actionChangePosition() {
        return $this->doActionByEntity(new ChangePositionListItem());
    }
}
