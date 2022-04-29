<?php

namespace App\Dao;

use PDO;
use Core\AbstractDao;
use App\Model\User;
use App\Model\Comment;

class CommentDao extends AbstractDao
{
    /**
     * Récupères de la base de données tous les commentaires
     *
     * @return Comment[] Tableau d'objet Comment
     */
    public function getAll(): array
    {
        $sth = $this->dbh->prepare("SELECT * FROM `comment`");
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < count($result); $i++) {
            $a = new Comment();
            $result[$i] = $a->setIdComment($result[$i]['id_comment'])
                ->setArticleId($result[$i]['article_id'])
                ->setUserId($result[$i]['user_id'])
                ->setContent($result[$i]['content'])
                ->setCreatedAt($result[$i]['created_at']);
        }

        return $result;
    }

    /**
     * Récupères de la base de données un commentaire en fonction de son id ou null si le commentaire n'existe pas
     *
     * @param int $id Identifiant du commentaire qu'on doit récupérer de la bdd
     * @return Comment|null Objet du commentaire récupéré en bdd ou null
     */
    public function getById(int $id): ?Comment
    {
        $sth = $this->dbh->prepare(
            "SELECT
            comment.id_comment,
            comment.article_id,
            comment.user_id,
            comment.content,
            comment.created_at
            
            FROM `comment`
            WHERE id_comment = :id_comment"
        );
        $sth->execute([":id_comment" => $id]);
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $user = null;

        if (isset($result['id_user'])) {
            $user = new User();
            $user->setIdUser($result['id_user'])
                ->setPseudo($result['pseudo'])
                ->setEmail($result['email'])
                ->setCreatedAt($result['user_created_at']);
        }

        $a = new Comment();
        return $a->setIdComment($result['id_comment'])
            ->setArticleId($result['article_id'])
            ->setUserId($result['user_id'])
            ->setContent($result['content'])
            ->setCreatedAt($result['created_at']);
    }


    /**
     * Récupères de la base de données tous les commentaires
     *
     * @return Comment[] Tableau d'objet Comment
     */
    public function getAllByArticleId(int $id): array
    {
        $sth = $this->dbh->prepare(
            "SELECT * FROM `comment`
            WHERE article_id = :article_id");
        
        $sth->execute([":article_id" => $id]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < count($result); $i++) {
            $a = new Comment();
            $result[$i] = $a->setIdComment($result[$i]['id_comment'])
                ->setArticleId($result[$i]['article_id'])
                ->setUserId($result[$i]['user_id'])
                ->setContent($result[$i]['content'])
                ->setCreatedAt($result[$i]['created_at']);
        }

        return $result;
    }


    /**
     * Ajoutes un commentaire à la base de données et assigne l'id du commentaire créé
     *
     * @param Comment $article Objet du commentaire à ajouter à la bdd
     */
    public function new(Comment $comment): void
    {
        $sth = $this->dbh->prepare(
            "INSERT INTO `comment` (content, article_id, user_id, created_at)
            VALUES (:content, :article_id, :user_id, NOW())"
        );
        $sth->execute([
            ':content' => $comment->getContent(),
            ':article_id' => $comment->getArticleId(),
            ':user_id' => $comment->getUserId()
        ]);
        $comment->setIdComment($this->dbh->lastInsertId());
    }

    /**
     * Edites un commentaire de la base de données
     *
     * @param Comment $comment Objet du commentaire à éditer
     */
    public function edit(Comment $comment): void
    {
        $sth = $this->dbh->prepare(
            "UPDATE `comment` SET content = :content WHERE id_comment = :id_comment"
        );
        $sth->execute([
            ':content' => $comment->getContent(),
            ':id_comment' => $comment->getIdComment()
        ]);
    }

    /**
     * Supprimes un commentaire de la base de données
     *
     * @param int $id Identifiant du commentaire à supprimer
     */
    public function delete(int $id): void
    {
        $sth = $this->dbh->prepare("DELETE FROM `comment` WHERE id_comment = :id_comment");
        $sth->execute([":id_comment" => $id]);
    }
}
