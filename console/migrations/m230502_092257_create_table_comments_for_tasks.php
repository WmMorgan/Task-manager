<?php

use yii\db\Migration;

/**
 * Class m230502_092257_create_table_comments_for_tasks
 */
class m230502_092257_create_table_comments_for_tasks extends Migration
{

    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {

            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%task_comments}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createIndex(
            'idx-comments-task_id',
            'task_comments',
            [
                'task_id',
                'user_id'
            ]
        );


        $this->addForeignKey(
            'fk-comments-task_id',
            'task_comments',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );

    }


    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-comments-task_id',
            'task_comments'
        );

        $this->dropIndex(
            'idx-comments-task_id',
            'task_comments'
        );

        $this->dropTable('{{%task_comments}}');

    }


}
