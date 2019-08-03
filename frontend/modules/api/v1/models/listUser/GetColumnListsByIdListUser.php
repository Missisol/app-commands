<?php

namespace frontend\modules\api\v1\models\listUser;

use frontend\modules\api\v1\models\entity\ColumnList;
use frontend\modules\api\v1\models\GetInfoByEntity;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\ListUser;

class GetColumnListsByIdListUser extends ValidationModel implements GetInfoByEntity
{
    public $id;

    public function rules()
    {
        return [
            ['id', 'required', 'message' => 'id не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => ListUser::class,
                 'message' => 'Списка пользователя с данным id не существует', ],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $columns = ColumnList::findAll([
            'id_list' => $this->id,
        ]);

        return [
            'columnLists' => $columns,
        ];
    }
}
