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
        $start = microtime(true);

        echo 'Parsing of repositories started' . PHP_EOL;
        $this->githubUserService->parseRepositories();

        echo 'Скрипт был выполнен за ' . (microtime(true) - $start) . ' секунд' . PHP_EOL;

        return ExitCode::OK;
    }
}
