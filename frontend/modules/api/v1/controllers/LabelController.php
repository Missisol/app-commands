<?php

namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\label\CreateNewLabel;
use frontend\modules\api\v1\models\label\UpdateLabel;

class LabelController extends ApiController
{
    public function actionCreate()
    {
        return $this->createNewEntity(new CreateNewLabel());
    }

    public function actionUpdate($id)
    {
        return $this->doActionByEntity(new UpdateLabel($id));
    }
}
