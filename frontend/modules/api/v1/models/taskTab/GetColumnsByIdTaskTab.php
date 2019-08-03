<?php

namespace frontend\modules\api\v1\models\taskTab;

use frontend\modules\api\v1\models\entity\Column;
use frontend\modules\api\v1\models\GetInfoByEntity;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\TaskTab;

class GetColumnsByIdTaskTab extends ValidationModel implements GetInfoByEntity
{
    public $id;

    public function rules()
    {
        return [
            ['id', 'required', 'message' => 'id не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskTab::class,
                 'message' => 'Вкладки задачи с данным id не существует', ],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        $columns = Column::findAll([
            'id_taskTab' => $this->id,
        ]);


        return [
            'columns' => $columns
        ];
    }
}
