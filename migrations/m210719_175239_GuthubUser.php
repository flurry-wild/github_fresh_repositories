<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m210719_175239_GuthubUser
 */
class m210719_175239_GuthubUser extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('github_user', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('github_user');
    }
}
