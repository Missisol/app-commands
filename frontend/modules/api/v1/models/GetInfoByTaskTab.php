<?php

namespace frontend\modules\api\v1\models;

use frontend\modules\api\v1\models\entity\Column;
use frontend\modules\api\v1\models\entity\Task;

class GetInfoByTaskTab
{
    private $id;

    /**
     * @param integer $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getInfo()
    {
        $columns = Column::findAll([
            'id_taskTab' => $this->id,
        ]);


        return [
            'columns' => $columns
        ];
    }
}
