<?php

use yii\db\Migration;

/**
 * Class m230425_121929_add_rights_column_to_user
 */
class m230504_105456_add_rights_column_to_user extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'rights', $this->integer()->defaultValue(null));
    }


    public function safeDown()
    {

        $this->dropColumn('{{%user}}', 'rights');

    }


}
