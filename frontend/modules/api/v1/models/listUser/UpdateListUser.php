<?php

namespace frontend\modules\api\v1\models\listUser;

use frontend\modules\api\v1\models\entity\ListUser;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class UpdateListUser extends ValidationModel implements ActionByEntity
{
    public $id;
    public $title;

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

            ['title', 'trim'],
            ['title', 'required', 'message' => 'Название списка задач не может быть пустым.'],
            ['title', 'string', 'max' => 255, 'tooLong' => 'Максимальная длина названия списка задач - 255 символов.'],
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $listUser = ListUser::findOne($this->id);
        $listUser->title = $this->title;

        return $listUser->save();
    }
}
