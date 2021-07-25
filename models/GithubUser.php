<?php

namespace app\models;

use yii\db\ActiveRecord;
use Exception;

class GithubUser extends ActiveRecord
{
    const URL_PREFIX = 'https://github.com/';

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{github_user}}';
    }

    /**
     * @param string $userName
     *
     * @return GithubUser
     */
    public static function create(string $userName): GithubUser
    {
        try {
            $githubUser = new static();
            $githubUser->name = $userName;

            $githubUser->save();

            return $githubUser;
        } catch (Exception $e) {
            die(sprintf('%s: %s', 'Invalid saving', $e->getMessage()));
        }
    }
}
