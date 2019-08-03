<?php

namespace frontend\modules\api\v1\models\board;

use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\entity\TaskTab;
use frontend\modules\api\v1\models\entity\ListUser;
use frontend\modules\api\v1\models\GetInfoByEntity;
use frontend\modules\api\v1\models\ValidationModel;

class GetInfoByBoard extends ValidationModel implements GetInfoByEntity
{
    private $user_id;

    public $id;

    /**
     * @param integer $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function rules()
    {
        return [
            ['id', 'default', 'value' => null],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Board::class,
                 'message' => 'Доски пользователя с данным id не существует', ],
        ];
    }

    public function getInfo()
    {
        if (!$this->validate()) {
            return false;
        }

        return $this->id ? $this->getInfoByOneBoard($this->id) : $this->getInitInfo();
    }

    private function getInitInfo()
    {
        $boards = Board::findAll([
            'id_user' => $this->user_id,
        ]);


        if (count($boards) > 0) {
            $idBoard = $boards[0]->id;

            return array_merge(
                [
                    'boards' => $boards
                ],
                $this->getInfoByOneBoard($idBoard)
            );
        }

        return array_merge(
            [
                'boards' => $boards
            ],
            $this->getInfoByOneBoardInArray()
        );
    }

    private function getInfoByOneBoard($idBoard)
    {
        $taskTabs = TaskTab::findAll([
            'id_board' => $idBoard,
        ]);

        $lists = ListUser::findAll([
            'id_board' => $idBoard,
        ]);

        return $this->getInfoByOneBoardInArray($taskTabs, $lists);
    }

    private function getInfoByOneBoardInArray($taskTabs = [], $lists = []) {
        return [
            'taskTabs' => $taskTabs,
            'lists' => $lists
        ];
    }
}
