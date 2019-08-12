<?php

use yii\db\Migration;

/**
 * Class m190810_140315_new_structure_table.
 */
class m190810_140315_new_structure_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%board}}', 'name', 'title');

        $this->renameColumn('{{%column}}', 'name', 'title');

        $this->renameColumn('{{%list}}', 'name', 'title');
        $this->addColumn('{{%list}}', 'position', $this->integer()->notNull());
        $this->dropForeignKey('fk_list_board', 'list');
        $this->renameColumn('{{%list}}', 'id_board', 'id_column');
        $this->addForeignKey(
            'fk_list_column',
            'list',
            'id_column',
            'column',
            'id'
        );

        $this->createTable('{{%label}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'id_board' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            'fk_label_board',
            'label',
            'id_board',
            'board',
            'id'
        );

        $this->renameColumn('{{%task}}', 'name', 'title');
        $this->addColumn('{{%task}}', 'position', $this->integer()->notNull());

        $this->createTable('{{%labelTask}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'id_task' => $this->integer()->notNull(),
            'id_label' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            'fk_labelTask_task',
            'labelTask',
            'id_task',
            'task',
            'id'
        );
        $this->addForeignKey(
            'fk_labelTask_label',
            'labelTask',
            'id_label',
            'label',
            'id'
        );

        $this->createTable('{{%listItem}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'execution' => $this->integer()->notNull(),
            'position' => $this->integer()->notNull(),
            'id_list' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            'fk_listItem_list',
            'listItem',
            'id_list',
            'list',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%listItem}}');

        $this->dropTable('{{%labelTask}}');

        $this->dropColumn('{{%task}}', 'position');
        $this->renameColumn('{{%task}}', 'title', 'name');

        $this->dropTable('{{%label}}');

        $this->dropForeignKey('fk_list_column', 'list');
        $this->renameColumn('{{%list}}', 'id_column', 'id_board');
        $this->addForeignKey(
            'fk_list_board',
            'list',
            'id_board',
            'board',
            'id'
        );
        $this->dropColumn('{{%list}}', 'position');
        $this->renameColumn('{{%list}}', 'title', 'name');

        $this->renameColumn('{{%column}}', 'title', 'name');

        $this->renameColumn('{{%board}}', 'title', 'name');
    }
}
