<?php

namespace frontend\modules\api\v1\models\listItem;

use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;
use frontend\modules\api\v1\models\entity\ListItem;

class UpdateListItem extends ValidationModel implements ActionByEntity
{
    public $id;
    public $title;
    public $execution;

    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'required', 'message' => 'id пункта задачи не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => ListItem::class,
                'message' => 'Пункта списка с данным id не существует', ],

            [['title'], 'trim'],
            [['title'], 'default'],
            ['title', 'string', 'max' => 255, 'message' => 'Максимальная длина названия пункта списка - 255 символов.'],
            ['execution', 'integer'],
            ['execution', 'in', 'range' => [ListItem::ITEM_NOT_DONE, ListItem::ITEM_DONE], 
                'message' => 'Значение исполнения может быть 0 (не исполнено) или 1 (исполнено)'],

            ['id', 'oneRequiredParam'],
        ];
    }

    public function oneRequiredParam()
    {
        if (!$this->hasErrors()) {
            if (null === $this->title && null === $this->execution) {
                $this->addError('params', 'Обязательно должно быть передано название (title) '.
                    'или исполнение пункта списка (execution).');
            }
        }
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $listItem = ListItem::findOne($this->id);

        if ($this->title) {
            $listItem->title = $this->title;
        }
        if ($this->execution !== null) {
            $listItem->execution = $this->execution;
        }

        return $listItem->save();
    }
}
