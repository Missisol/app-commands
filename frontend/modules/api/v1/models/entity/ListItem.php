<?php

namespace frontend\modules\api\v1\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "listItem".
 *
 * @property int $id
 * @property string $title
 * @property int $execution
 * @property int $position
 * @property int $id_list
 * @property int $created_at
 * @property int $updated_at
 *
 * @property List $list
 */
class ListItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'listItem';
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
            [['title', 'execution', 'position', 'id_list', 'created_at', 'updated_at'], 'required'],
            [['execution', 'position', 'id_list', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id_list'], 'exist', 'skipOnError' => true, 'targetClass' => ListUser::class, 'targetAttribute' => ['id_list' => 'id']],
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
            'execution' => 'Execution',
            'position' => 'Position',
            'id_list' => 'Id List',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(ListUser::class, ['id' => 'id_list']);
    }
}
