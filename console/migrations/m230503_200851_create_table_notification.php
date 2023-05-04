<?php

use yii\db\Migration;

/**
 * Class m230503_200851_create_table_nofitication
 */
class m230503_200851_create_table_notification extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {

            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'key' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'idx-notification-user_id',
            'notification',
            [
                'user_id'
            ]
        );


        $this->addForeignKey(
            'fk-notification-user_id',
            'notification',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'fk-notification-user_id',
            'notification'
        );

        $this->dropIndex(
            'idx-notification-user_id',
            'notification'
        );

        $this->dropTable('notification');
    }


}
