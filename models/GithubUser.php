<?php

namespace app\models;

use app\services\GithubService;
use app\services\ParseService;
use yii\db\ActiveRecord;
use Exception;
use KubAT\PhpSimple\HtmlDomParser;
use Yii;

class GithubUser extends ActiveRecord
{
    const URL_PREFIX = 'https://github.com/';
    const ERROR_NOT_EXIST_REPOSITORY = 'На https://github.com не существует такого пользователя';

    /**
     * @return ParseService
     */
    public function getParseService(): ParseService
    {
        return new ParseService();
    }

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

            if ($githubUser->validate()) {
                $githubUser->save();
            }

            return $githubUser;
        } catch (Exception $e) {
            die(sprintf('%s: %s', 'Invalid saving', $e->getMessage()));
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string'],
            ['name', 'unique'],
            ['name', 'checkExistGithubUser'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function checkExistGithubUser($attribute, $params)
    {
        try {
            $dom = HtmlDomParser::file_get_html(sprintf('%s/%s', GithubService::URL_PREFIX, $this->name));

            $title = $this->getParseService()->parseContainer($dom, ['title'])->plaintext;
            if ($title !== sprintf('%s · GitHub', $this->name)) {
                $this->addError($attribute, Yii::t('app', self::ERROR_NOT_EXIST_REPOSITORY));
            }
        } catch (Exception $e) {
            $this->addError($attribute, Yii::t('app', self::ERROR_NOT_EXIST_REPOSITORY));
        }
    }
}
