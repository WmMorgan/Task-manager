<?php

use yii\db\Migration;


class m230502_091555_create_table_tasks extends Migration
{

    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {

            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'responsible' => $this->integer(),
            'name' => $this->string()->notNull(),
            'deadline' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createIndex(
            'idx-post-user_id',
            'tasks',
            'user_id'
        );


        $this->addForeignKey(
            'fk-post-user_id',
            'tasks',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    public function safeDown()
    {

        $this->dropForeignKey(
            'fk-post-user_id',
            'tasks'
        );

        $this->dropIndex(
            'idx-post-user_id',
            'tasks'
        );

        $this->dropTable('{{%tasks}}');

    }


}
