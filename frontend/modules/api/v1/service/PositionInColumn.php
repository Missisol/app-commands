<?php

namespace frontend\modules\api\v1\service;

use frontend\modules\api\v1\models\entity\ListUser;
use frontend\modules\api\v1\models\entity\Task;

class PositionInColumn
{
    private const INCREASE_POSITION = 100;

    public static function calculationNewPosition()
    {
        $maxPositionTask = Task::find()
            ->where(['id_column' => $this->id_column])
            ->max('position');

        $maxPositionListUser = ListUser::find()
            ->where(['id_column' => $this->id_column])
            ->max('position');

        return max($maxPositionTask, $maxPositionListUser) + self::INCREASE_POSITION;
    }
}