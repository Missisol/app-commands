<?php

namespace frontend\modules\api\v1\models\entity;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "task".
 *
 * @property int         $id
 * @property string      $title
 * @property string      $description
 * @property int         $id_column
 * @property int         $created_at
 * @property int         $updated_at
 * @property int         $position
 * @property LabelTask[] $labelTasks
 * @property Column      $column
 */
class Task extends \yii\db\ActiveRecord
{
    public $labels;

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
            [['title', 'id_column', 'created_at', 'updated_at', 'position'], 'required'],
            [['description'], 'string'],
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
            'description' => 'Description',
            'id_column' => 'Id Column',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'position' => 'Position',
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

    public function setLabels($value)
    {
        $this->labels = $value;
    }

    public function getLabels()
    {
        return $this->labels;
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'description',
            'position',
            'labels',
        ];
    }

    public function afterFind()
    {
        $this->labels = ArrayHelper::getColumn($this->labelTasks, 'id_label');    
    }
}
