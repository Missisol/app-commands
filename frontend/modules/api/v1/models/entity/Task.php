<?php

namespace frontend\modules\api\v1\models\entity;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $id_column
 * @property int $created_at
 * @property int $updated_at
 * @property int $position
 * @property int $id_labelTask
 *
 * @property LabelTask[] $labelTasks
 * @property Column $column
 * @property LabelTask $labelTask
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
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
            [['title', 'id_column', 'created_at', 'updated_at', 'position', 'id_labelTask'], 'required'],
            [['id_column', 'created_at', 'updated_at', 'position', 'id_labelTask'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['id_column'], 'exist', 'skipOnError' => true, 'targetClass' => Column::class, 'targetAttribute' => ['id_column' => 'id']],
            [['id_labelTask'], 'exist', 'skipOnError' => true, 'targetClass' => LabelTask::class, 'targetAttribute' => ['id_labelTask' => 'id']],
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
            'description' => 'Description',
            'id_column' => 'Id Column',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'position' => 'Position',
            'id_labelTask' => 'Id Label Task',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabelTasks()
    {
        return $this->hasMany(LabelTask::class, ['id_task' => 'id']);
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
    public function getLabelTask()
    {
        return $this->hasOne(LabelTask::class, ['id' => 'id_labelTask']);
    }
    
    public function fields()
    {
        return [
            'id',
            'name',
            'description'
        ];
    }
}
