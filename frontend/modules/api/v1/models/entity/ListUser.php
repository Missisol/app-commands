<?php

namespace frontend\modules\api\v1\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "list".
 *
 * @property int $id
 * @property string $name
 * @property int $id_board
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ColumnList[] $columnlists
 * @property Board $board
 */
class ListUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'list';
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
            [['name', 'id_board', 'created_at', 'updated_at'], 'required'],
            [['id_board', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'id_board' => 'Id Board',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumnlists()
    {
        return $this->hasMany(ColumnList::class, ['id_list' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoard()
    {
        return $this->hasOne(Board::class, ['id' => 'id_board']);
    }

    public function fields()
    {
        return [
            'id',
            'name'
        ];
    }
}
