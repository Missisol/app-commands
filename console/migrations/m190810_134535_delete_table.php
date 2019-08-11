<?php

use yii\db\Migration;

/**
 * Class m190810_134535_delete_table
 */
class m190810_134535_delete_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_column_taskTab', 'column');
        $this->renameColumn('{{%column}}', 'id_taskTab', 'id_board');
        $this->addForeignKey(
            'fk_column_board', 
            'column', 
            'id_board', 
            'board', 
            'id'
        );

        $this->dropTable('{{%taskTab}}');

        $this->dropTable('{{%issue}}');

        $this->dropTable('{{%listIssue}}');

        $this->dropTable('{{%columnList}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
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

        $this->dropForeignKey('fk_column_board', 'column');
        $this->renameColumn('{{%column}}', 'id_board', 'id_taskTab');
        $this->addForeignKey(
            'fk_column_taskTab', 
            'column', 
            'id_taskTab', 
            'taskTab', 
            'id'
        );
    }
}
