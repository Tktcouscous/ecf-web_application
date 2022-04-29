<?php

require_once VIEW . DIRECTORY_SEPARATOR . 'header.html.php';
?>
    <article class="p-3 border border-1 rounded mb-3" id="article<?= $comment->getIdComment() ?>">
        <h5>Posted by <?= filter_var($comment->getUserId() ?? 'Anonymous', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></h5>
        <h5><?= filter_var($comment->getCreatedAt(), FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></h5>
        <hr>
        <p><?= nl2br(filter_var($comment->getContent(), FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?></p>
        <?php
        if (isset($_SESSION['user'])) :
            ?>
            <hr>
            <ul class="nav">
                <li class="nav-item me-2">
                    <a class="nav-link btn btn-light text-dark"
                       href="<?= sprintf("/comment/edit/%d", $comment->getIdComment()) ?>">Edit</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link btn btn-danger text-light"
                       href="<?= sprintf("/comment/delete/%d", $comment->getIdComment()) ?>">Delete</a>
                </li>
            </ul>
        <?php
        endif;
        ?>
    </article>
<?php
require_once VIEW . DIRECTORY_SEPARATOR . "footer.html.php";
?>