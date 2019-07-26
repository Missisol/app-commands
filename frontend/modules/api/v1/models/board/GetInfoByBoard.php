<?php

namespace frontend\modules\api\v1\models\board;

use frontend\modules\api\v1\models\entity\Board;
use frontend\modules\api\v1\models\entity\TaskTab;
use frontend\modules\api\v1\models\entity\ListUser;

class GetInfoByBoard
{
    private $user_id;
    private $id;

    /**
     * @param integer $user_id
     */
    public function __construct($user_id, $id)
    {
        $this->user_id = $user_id;
        $this->id = $id;
    }

    public function getInfo()
    {
        return $this->id === null ? $this->getInitInfo() : $this->getInfoByOneBoard($this->id);
    }

    private function getInitInfo()
    {
        $boards = Board::findAll([
            'id_user' => $this->user_id,
        ]);


        if (count($boards) >= 1) {
            $idBoard = $boards[0]->id;

            return array_merge(
                [
                    'boards' => $boards
                ],
                $this->getInfoByOneBoard($idBoard)
            );
        }

        return [
            'boards' => $boards,
            'taskTabs' => [],
            'lists' => []
        ];
    }

    private function getInfoByOneBoard($idBoard)
    {
        $taskTabs = TaskTab::findAll([
            'id_board' => $idBoard,
        ]);

        $lists = ListUser::findAll([
            'id_board' => $idBoard,
        ]);

        return [
            'taskTabs' => $taskTabs,
            'lists' => $lists
        ];
    }
}
