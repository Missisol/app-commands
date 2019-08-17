<?php

namespace frontend\modules\api\v1\models\listItem;

use frontend\modules\api\v1\models\entity\Task;
use frontend\modules\api\v1\models\entity\Column;
use frontend\modules\api\v1\models\entity\ListUser;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;
use frontend\modules\api\v1\models\entity\ListItem;

class ChangePositionListItem extends ValidationModel implements ActionByEntity
{
    public $id;
    public $position;
    public $id_list;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'required', 'message' => 'id пунка списка не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class,
                'message' => 'Пункта списка с данным id не существует', ],

            ['position', 'integer'],
            ['position', 'required', 'message' => 'Позиция не может быть пустой.'],

            ['id_list', 'required', 'message' => 'id_list не может быть пустым.'],
            ['id_list', 'integer'],
            [['id_list'], 'exist', 'skipOnError' => true, 'targetClass' => ListUser::class, 'targetAttribute' => ['id_list' => 'id'], 'message' => 'Список с данным id_list не существует'],

            ['position', 'suitablePositionValue'],
        ];
    }

    public function suitablePositionValue()
    {
        if (!$this->hasErrors()) {
            $listItem = ListItem::findOne([
                'id_list' => $this->id_list,
                'position' => $this->position,
            ]);
            if ($listItem) {
                $this->addError('params', 'Данная позиция в этом списке уже занята');
            }
        }
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $listItem = ListItem::findOne($this->id);
        $listItem->position = $this->position;

        return $listItem->save();
    }
}
