<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m210720_123716_GithubRepository
 */
class m210720_123716_GithubRepository extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('github_repository', [
            'id' => Schema::TYPE_PK,
            'url' => Schema::TYPE_STRING . ' NOT NULL',
            'github_user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'last_update' => Schema::TYPE_STRING,
        ]);

        $this->addForeignKey(
            'fk_github_user_id',
            'github_repository',
            'github_user_id',
            'github_user',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('github_repository');
    }
}
