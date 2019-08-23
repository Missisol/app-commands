<?php

namespace frontend\modules\api\v1\models\task;

use Yii;
use frontend\modules\api\v1\models\entity\Task;
use frontend\modules\api\v1\models\ValidationModel;
use frontend\modules\api\v1\models\ActionByEntity;
use frontend\modules\api\v1\models\entity\Label;
use frontend\modules\api\v1\models\entity\LabelTask;
use yii\helpers\ArrayHelper;

class UpdateTask extends ValidationModel implements ActionByEntity
{
    private const LABEL_ERROR = 'labels должен быть массивом id ярлыков';

    public $id;
    public $title;
    public $description;
    public $labels;

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
            ['id', 'required', 'message' => 'id задачи не может быть пустым.'],
            ['id', 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class,
                'message' => 'Задачи с данным id не существует', ],

            [['title', 'description'], 'trim'],
            [['title', 'description'], 'default'],
            ['title', 'string', 'max' => 255, 'message' => 'Максимальная длина названия задачи - 255 символов.'],
            ['description', 'string'],

            [['labels'], 'each', 'rule' => ['exist', 'skipOnError' => true, 'targetClass' => Label::class, 'targetAttribute' => ['labels' => 'id'], 'message' => self::LABEL_ERROR], 'message' => self::LABEL_ERROR],

            ['id', 'oneRequiredParam'],
        ];
    }

    public function oneRequiredParam()
    {
        if (!$this->hasErrors()) {
            if (null == $this->title && null == $this->description && null === $this->labels) {
                $this->addError('params', 'Обязательно должно быть передано название (title), '.
                    'описание задачи (description) или массив ярлыков (labels).');
            }
        }
    }

    public function doAction()
    {
        if (!$this->validate()) {
            return false;
        }

        if (null !== $this->labels) {
            return $this->changeLabels();
        }

        return $this->changeTask();
    }

    private function changeTask()
    {
        $task = Task::findOne($this->id);

        if ($this->title) {
            $task->title = $this->title;
        }
        if ($this->description) {
            $task->description = $this->description;
        }

        return $task->save();
    }

    private function changeLabels()
    {
        $labelsDb = LabelTask::findAll(['id_task' => $this->id]);
        $labels = ArrayHelper::getColumn($labelsDb, 'id_label');

        $addLabels = [];
        $deleteLabels = [];

        foreach ($this->labels as $idLabelNew) {
            if (!in_array($idLabelNew, $labels)) {
                $addLabels[] = $idLabelNew;
            }
        }

        foreach ($labels as $idLabelDb) {
            if (!in_array($idLabelDb, $this->labels)) {
                $deleteLabels[] = $idLabelDb;
            }
        }

        return $this->saveLabels($addLabels, $deleteLabels);
    }

    private function saveLabels($addLabels, $deleteLabels)
    {
        $transaction = Yii::$app->db->beginTransaction();

        foreach ($addLabels as $idLabel) {
            $labelTask = new LabelTask([
                'id_task' => (int) $this->id,
                'id_label' => $idLabel,
            ]);

            if (!$labelTask->save()) {
                $transaction->rollback();

                return false;
            }
        }

        foreach ($deleteLabels as $idLabel) {
            $labelTask = LabelTask::findOne([
                'id_task' => $this->id,
                'id_label' => $idLabel,
            ]);
            if (!$labelTask->delete()) {
                $transaction->rollback();

                return false;
            }
        }

        $transaction->commit();

        return true;
    }
}
