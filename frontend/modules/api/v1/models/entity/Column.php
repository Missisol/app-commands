<?php

namespace frontend\modules\api\v1\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "column".
 *
 * @property int $id
 * @property string $title
 * @property int $id_board
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Board $board
 * @property ListUser[] $lists
 * @property Task[] $tasks
 */
class Column extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'column';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'id_board', 'created_at', 'updated_at'], 'required'],
            [['id_board', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id_board'], 'exist', 'skipOnError' => true, 'targetClass' => Board::class, 'targetAttribute' => ['id_board' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'id_board' => 'Id Board',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoard()
    {
        return $this->hasOne(Board::class, ['id' => 'id_board']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLists()
    {
        return $this->hasMany(ListUser::class, ['id_column' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['id_column' => 'id']);
    }

    public function fields()
    {
        return [
            'id',
            'title'
        ];
    }
}
