<?php

namespace app\models;

use yii\db\ActiveRecord;
use Exception;

class GithubRepository extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{github_repository}}';
    }

    /**
     * @param array $data
     *
     * @return GithubRepository
     */
    public static function create(array $data): GithubRepository
    {
        try {
            $githubRepository = new static();
            $githubRepository->github_user_id = $data['github_user_id'];
            $githubRepository->url = $data['url'];
            $githubRepository->last_update = $data['last_update'];

            $githubRepository->save();

            return $githubRepository;
        } catch (Exception $e) {
            die(sprintf('%s: %s', 'Invalid saving', $e->getMessage()));
        }
    }
}
