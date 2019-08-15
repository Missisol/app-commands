<?php

namespace frontend\modules\api\v1\models\label;

use frontend\modules\api\v1\models\entity\Label;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;

class UpdateLabel extends ValidationModel implements ActionByEntity
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
            ['id', 'required', 'message' => 'id ярлыка не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Label::class,
                'message' => 'Ярлыка с данным id не существует', ],

            ['title', 'trim'],
            ['title', 'required', 'message' => 'Название ярлыка не может быть пустым.'],
            ['title', 'string', 'max' => 255, 'message' => 'Максимальная длина названия ярлыка - 255 символов.']
        ];
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        $label = Label::findOne($this->id);
        $label->title = $this->title;

        return $label->save();
    }
}
