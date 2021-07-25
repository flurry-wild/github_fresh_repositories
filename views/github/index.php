<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Github Users';

?>

<h1>Пользователи github</h1>

<div class="github-add-form">
    <form action="/github/store" method="post">
        <input type="hidden" name="<?=Yii::$app->request->csrfParam; ?>" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
        <div class="github-url">https://github.com/</div>
        <input type="text" name="user">
        <input type="submit" value="Добавить" class="btn btn-primary">
    </form>

    <div class="github-user-list col-md-6">
        <ul class="list-group">
                <?php foreach ($githubUsers as $user) { ?>
                        <?= '<li class="list-group-item"><a href="https://github.com/' . Html::encode($user->name) . '">
                        https://github.com/' . Html::encode($user->name) . '</a></li>' ?>
                <?php } ?>
        </ul>
    </div>
</div>
