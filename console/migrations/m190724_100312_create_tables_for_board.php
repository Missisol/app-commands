<?php

use yii\db\Migration;

/**
 * Class m190724_100312_create_tables_for_board
 */
class m190724_100312_create_tables_for_board extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%board}}', 'created_at', $this->integer()->notNull());
        $this->addColumn('{{%board}}', 'updated_at', $this->integer()->notNull());
        $this->renameColumn('{{%board}}', 'user_id', 'id_user');

        $this->createTable('{{%taskTab}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'id_board' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_taskTab_board', 
            'taskTab', 
            'id_board', 
            'board', 
            'id'
        );

        $this->createTable('{{%column}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'id_taskTab' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_column_taskTab', 
            'column', 
            'id_taskTab', 
            'taskTab', 
            'id'
        );

        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'id_column' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_task_column', 
            'task',
            'id_column',
            'column', 
            'id'
        );

        $this->createTable('{{%list}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'id_board' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_list_board', 
            'list', 
            'id_board', 
            'board', 
            'id'
        );

        $this->createTable('{{%columnList}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'id_list' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_columnList_list', 
            'columnList', 
            'id_list', 
            'list', 
            'id'
        );

        $this->createTable('{{%listIssue}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'id_columnList' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_lisIssue_columnList',
            'listIssue',
            'id_columnList',
            'columnList', 
            'id'
        );

        $this->createTable('{{%issue}}', [
            'id' => $this->primaryKey(),
            'description' => $this->string()->notNull(),
            'execution' => $this->smallInteger()->notNull()->defaultValue(0),
            'id_listIssue' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_issue_listIssue', 
            'issue',
            'id_listIssue',
            'listIssue', 
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%issue}}');

        $this->dropTable('{{%listIssue}}');

        $this->dropTable('{{%columnList}}');

        $this->dropTable('{{%list}}');

        $this->dropTable('{{%task}}');

        $this->dropTable('{{%column}}');

        $this->dropTable('{{%taskTab}}');

        $this->dropColumn('{{%board}}', 'created_at');
        $this->dropColumn('{{%board}}', 'updated_at');
        $this->renameColumn('{{%board}}', 'id_user', 'user_id');
    }
}
