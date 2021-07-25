<h1>10 самых свежих репозиториев пользователей</h1>

<?php foreach ($repositories as $key => $repository) { ?>
    <div class="col-md-12">
        <ul class="list-group">
            <li class="list-group-item item-box">
                <div class="item-inner-box">
                    <div class="repository-box">
                        <?= ($key+1) ?> .
                        <a href="https://github.com<?= $repository->url ?>">
                            https://github.com<?= $repository->url ?>
                        </a>
                    </div> <?= $repository->last_update ?>
                </div>
            </li><br>
        </ul>
    </div>
<?php } ?>
