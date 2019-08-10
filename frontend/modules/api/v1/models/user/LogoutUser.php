<?php

namespace frontend\modules\api\v1\models\user;

use Yii;
use frontend\modules\api\v1\models\DeleteEntity;

class LogoutUser implements DeleteEntity
{
    public function delete()
    {
        Yii::$app->response->headers->remove('Authorization');
        return true;
    }
}
