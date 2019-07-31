<?php

namespace frontend\modules\api\v1\models\listUser;

use frontend\modules\api\v1\models\entity\ColumnList;
use frontend\modules\api\v1\models\GetInfoByEntity;

class GetInfoByListUser implements GetInfoByEntity
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
