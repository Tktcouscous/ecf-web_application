<?php

namespace App\Controller;

use PDOException;
use App\Model\Comment;
use App\Dao\CommentDao;

class CommentController
{
    /**
     * Action d'afficher tous les commentaires
     */
    public function index()
    {
        try {
            $commentDao = new CommentDao();
            $comments = $commentDao->getAll();
            require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'comment', 'index.html.php']);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    /**
     * Action de créer un nouveau commentaire
     */
    public function new($id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /signin');
            die;
        }

        $userid = ($_SESSION['user'])->getIdUser();

        $args = [
            'content' => []
        ];
        $comment_post = filter_input_array(INPUT_POST, $args);

        if (isset($comment_post['content'])) {
            if (empty(trim($comment_post['content']))) {
                $error_messages['danger'][] = "Contenu inexistant";
            }

            if (!isset($error_messages)) {
                $comment = new Comment();
                $comment->setContent($comment_post['content'])
                ->setArticleId($id)
                ->setUserId($userid);

                try {
                    $commentDao = new CommentDao();
                    $commentDao->new($comment);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    die;
                }

                header(sprintf('Location: /article/%d', $id));
                die;
            }
        }

        require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'comment', 'new.html.php']);
    }

    /**
     * Action d'afficher un commentaire en fonction de son id
     *
     * @param int $id Identifiant du commentaire à afficher
     */
    public function show(int $id)
    {
        try {
            $commentDao = new CommentDao();
            $comment = $commentDao->getById($id);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }

        if (is_null($comment)) {
            header('Location: /');
            die;
        }

        require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'comment', 'show.html.php']);
    }

/**
     * Action d'afficher tous les commentaires relatifs à un article_id
     *
     * @param int $id Identifiant de l'article associé
     */
    public function showByArticleId(int $id)
    {
        try {
            $commentDao = new CommentDao();
            $comments = $commentDao->getAllByArticleId($id);
            require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'article', 'show.html.php']);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    /**
     * Action d'éditer un commentaire en fonction de son identifiant
     *
     * @param int $id Identifiant du commentaire à éditer
     */
    public function edit(int $id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            die;
        }

        try {
            $comment = new Comment();
            $id_com = "#".$id;
            $commentDao = new CommentDao();
            $id_temp = $commentDao->getById($id)->getArticleId();
            $comment = $commentDao->getById($id);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }

        if (is_null($comment)) {
            header('Location: /');
            die;
        }

        $args = [
            'content' => []
        ];
        $comment_post = filter_input_array(INPUT_POST, $args);

        if (isset($comment_post['content'])) {
            if (empty(trim($comment_post['content']))) {
                $error_messages['danger'][] = "Contenu inexistant";
            }

            if (!isset($error_messages)) {
                $comment->setContent($comment_post['content']);

                try {
                    $commentDao->edit($comment);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    die;
                }

                header(sprintf('Location: /article/%d%s', $id_temp,$id_com));
                die;
            }
        }

        require_once implode(DIRECTORY_SEPARATOR, [VIEW, 'comment', 'edit.html.php']);
    }

    /**
     * Action de supprimer un commentaire en fonction de son identifiant
     *
     * @param int $id Identifiant du commentaire à supprimer
     */
    public function delete(int $id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /');
            die;
        }

        try {
            $commentDao = new CommentDao();
            $id_temp = $commentDao->getById($id)->getArticleId();
            $commentDao->delete($id);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }

        header(sprintf('Location: /article/%d', $id_temp));
        die;
    }
}
