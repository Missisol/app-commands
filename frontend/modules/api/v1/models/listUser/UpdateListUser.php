<?php

namespace frontend\modules\api\v1\models\listUser;

use frontend\modules\api\v1\models\entity\ListUser;
use frontend\modules\api\v1\models\entity\Column;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class UpdateListUser extends ValidationModel implements ActionByEntity
{
    public $id;
    public $id_column;

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
            ['id', 'required', 'message' => 'id задачи не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => ListUser::class,
                'message' => 'списка с данным id не существует', ],

            ['id_column', 'integer'],
            [['id_column'], 'exist', 'skipOnError' => true, 'targetClass' => Column::class, 'targetAttribute' => ['id_column' => 'id'], 'message' => 'Колонка с данным id_column не существует'],

            ['id', 'oneRequiredParam'],
        ];
    }

    public function oneRequiredParam()
    {
        if (!$this->hasErrors()) {
            if (null == $this->id_column) {
                $this->addError('params', 'Обязательно должно быть передан номер колонки (id_column)');
            }
        }
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $listUser = ListUser::findOne($this->id);

        if ($this->id_column) {
            $listUser->id_column = $this->id_column;
        }

        return $listUser->save();
    }
}
