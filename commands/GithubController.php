<?php

namespace app\commands;

use app\services\GithubService;
use yii\console\Controller;
use yii\console\ExitCode;

class GithubController extends Controller
{
    protected $githubUserService;

    /**
     * GithubController constructor.
     *
     * @param GithubService $githubUserService
     * @param $id
     * @param $module
     * @param array $config
     */
    public function __construct($id, $module, $config, GithubService $githubUserService)
    {
        parent::__construct($id, $module, $config);

        $this->githubUserService = $githubUserService;
    }

    public function actionIndex()
    {
        echo 'Parsing of repositories started' . "\n";
        $this->githubUserService->parseRepositories();

        return ExitCode::OK;
    }
}
