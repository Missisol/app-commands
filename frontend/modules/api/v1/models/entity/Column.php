<?php

namespace frontend\modules\api\v1\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "column".
 *
 * @property int $id
 * @property string $name
 * @property int $id_taskTab
 * @property int $created_at
 * @property int $updated_at
 *
 * @property TaskTab $taskTab
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
            [['name', 'id_taskTab', 'created_at', 'updated_at'], 'required'],
            [['id_taskTab', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_taskTab'], 'exist', 'skipOnError' => true, 'targetClass' => TaskTab::class, 'targetAttribute' => ['id_taskTab' => 'id']],
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
            'id_taskTab' => 'Id Task Tab',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskTab()
    {
        return $this->hasOne(TaskTab::class, ['id' => 'id_taskTab']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['id_column' => 'id']);
    }
}
