<?php

namespace frontend\modules\api\v1\models\column;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\entity\TaskTab;
use frontend\modules\api\v1\models\entity\Column;

class CreateNewColumn extends ValidationModel
{
    public $name;
    public $id_taskTab;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required', 'message' => 'Название колонки не может быть пустым.'],
            ['name', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия колонки - 255 символов.'],

            ['id_taskTab', 'required', 'message' => 'id_taskTab не может быть пустым.'],
            ['id_taskTab', 'integer'],
            [['id_taskTab'], 'exist', 'skipOnError' => true, 'targetClass' => TaskTab::class, 'targetAttribute' => ['id_taskTab' => 'id'], 'message' => 'Вкладка задач с данным id_taskTab не существует'],
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $column = new Column([
            'name' => $this->name,
            'id_taskTab' => $this->id_taskTab
        ]);

        return $column->save(false);
    }
}
