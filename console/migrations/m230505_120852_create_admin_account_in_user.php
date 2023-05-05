<?php


use yii\db\Migration;

/**
 * Class m230425_122223_create_admin_account_in_user
 */
class m230505_120852_create_admin_account_in_user extends Migration
{

    /**
     * Table name
     *
     * @var string
     */
    private $_user = "{{%user}}";

    /**
     * Runs for the migate/up command
     *
     * @return null
     */
    public function safeUp()
    {
        $time = time();
        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('admin');
        $auth_key = Yii::$app->security->generateRandomString();
        $table = $this->_user;

        $sql = <<<SQL
        INSERT INTO {$table}
        (`username`, `email`,`password_hash`, `auth_key`, `created_at`, `updated_at`, `rights`)
        VALUES
        ('admin', 'admin@yoursite.com',  '$password_hash', '$auth_key', {$time}, {$time}, '10')
SQL;
        Yii::$app->db->createCommand($sql)->execute();

    }

    /**
     * Runs for the migate/down command
     *
     * @return null
     */
    public function safeDown()
    {
        $this->delete($this->_user, ['username' => 'admin']);

    }

}
