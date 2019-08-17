<?php

namespace frontend\modules\api\v1\models\entity;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "list".
 *
 * @property int        $id
 * @property string     $title
 * @property int        $id_column
 * @property int        $created_at
 * @property int        $updated_at
 * @property int        $position
 * @property Column     $column
 * @property ListItem[] $listItems
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
            [['title', 'id_column', 'created_at', 'updated_at', 'position'], 'required'],
            [['id_column', 'created_at', 'updated_at', 'position'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id_column'], 'exist', 'skipOnError' => true, 'targetClass' => Column::class, 'targetAttribute' => ['id_column' => 'id']],
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
            'id_column' => 'Id Column',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColumn()
    {
        return $this->hasOne(Column::class, ['id' => 'id_column']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListItems()
    {
        return $this->hasMany(ListItem::class, ['id_list' => 'id']);
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'position',
            'listItems',
        ];
    }
}
