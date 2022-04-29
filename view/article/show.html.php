<?php require_once VIEW . DIRECTORY_SEPARATOR . 'header.html.php'; ?>
    <article class="p-3 border border-1 rounded mb-3" id="article<?= $article->getIdArticle() ?>">
        <h1><?= filter_var($article->getTitle(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></h1>
        <h5><?= filter_var($article->getCreatedAt(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></h5>
        <h5>Posted by <?= filter_var($article->getUser()?->getPseudo() ?? 'Anonymous', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></h5>
        <hr>
        <p><?= nl2br(filter_var($article->getContent(), FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?></p>
        <hr>
        <!-- BOUTON ADD COMMENT -->
        <ul class="nav">
            <li class="nav-item me-2">
                <a class="nav-link btn btn-secondary text-light" href="<?= sprintf("/article/%d/comment/new", $article->getIdArticle()) ?>">Add comment</a>
            </li>
            <?php if (isset($_SESSION['user'])) : ?>
                <li class="nav-item me-2">
                    <a class="nav-link btn btn-info text-dark" href="<?= sprintf("/article/edit/%d", $article->getIdArticle()) ?>">Edit</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link btn btn-danger text-light" href="<?= sprintf("/article/delete/%d", $article->getIdArticle()) ?>">Delete</a>
                </li>
            <?php endif; ?>
        </ul>
    </article>
    <h2 style="margin:50px 0 10px 0">COMMENTAIRES</h2>
    <?php foreach ($comments as $comment) : ?>
    <comment class="container my-5 py-5" id="<?= $comment->getIdComment() ?>">
        <div class="row d-flex justify-content-center">
            <div class="p3 mb-3">
                <div class="card text-dark">
                    <div class="card-body p-4 bg-light">
                        <h3 class="fw-bold mb-1"><?= filter_var($article->getUser($comment->getUserId())->getPseudo() ?? 'Anonymous', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></h3>
                        <div class="d-flex align-items-center mb-3">
                            <h5 class="mb-0"><?= filter_var($comment->getCreatedAt(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></h5>
                        </div>
                        <hr>
                        <p style="margin:50px 0 50px 0"><?= nl2br(filter_var($comment->getContent(), FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?></p>
                        <ul class="nav">
                            <?php if (isset($_SESSION['user'])) : ?>
                                <li class="nav-item me-2">
                                    <a class="nav-link btn btn-info text-dark" href="<?= sprintf("/comment/edit/%d", $comment->getIdComment()) ?>">Edit</a>
                                </li>
                                <li class="nav-item me-2">
                                    <a class="nav-link btn btn-danger text-light" href="<?= sprintf("/comment/delete/%d", $comment->getIdComment()) ?>">Delete</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </comment>
<?php endforeach; ?>
<?php require_once VIEW . DIRECTORY_SEPARATOR . "footer.html.php"; ?>