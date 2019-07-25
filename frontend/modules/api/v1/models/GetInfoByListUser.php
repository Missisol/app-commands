<?php

namespace frontend\modules\api\v1\models;

use frontend\modules\api\v1\models\entity\ColumnList;

class GetInfoByListUser
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
        $columns = ColumnList::findAll([
            'id_list' => $this->id,
        ]);


        return [
            'columnLists' => $columns
        ];
    }
}
