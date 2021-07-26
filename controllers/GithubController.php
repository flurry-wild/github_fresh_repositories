<?php

namespace app\controllers;

use app\models\GithubRepository;
use app\models\GithubUser;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;

class GithubController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $githubUsers = GithubUser::find()->all();

        return $this->render('index', compact('githubUsers'));
    }

    public function actionStore()
    {
        $userName = Yii::$app->request->post('user');

        $githubUser = GithubUser::create($userName);

        Yii::$app->response->redirect(Url::to([
            '/github/index',
            'githubUserName' => $githubUser->name,
            'errors' => $githubUser->errors,
        ]));
    }

    /**
     * @return string
     */
    public function actionRepositoryIndex()
    {
        $repositories = GithubRepository::find()
            ->orderBy(['last_update' => SORT_DESC])
            ->limit(10)
            ->all();

        return $this->render('/github-repository/index', compact('repositories'));
    }
}
