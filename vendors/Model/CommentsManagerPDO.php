<?php
namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager
{
    protected function add(Comment $comment)
    {
        $q = $this->dao->prepare('INSERT INTO comments SET news = :news, auteur = :auteur, contenu = :contenu, date = NOW()');
        $q->bindValue(':news', $comment->getNews(), \PDO::PARAM_INT);
        $q->bindValue(':auteur', $comment->getAuteur());
        $q->bindValue(':contenu', $comment->getContenu());

        $q->execute();

        $comment->setId($this->dao->lastInsertId());
    }

    protected function modify(Comment $comment)
    {
        $q = $this->dao->prepare('UPDATE comments SET auteur = :auteur, contenu = :contenu WHERE id = :id');
        $q->bindValue(':auteur', $comment->getAuteur());
        $q->bindValue(':contenu', $comment->getContenu());
        $q->bindValue(':id', $comment->getId(), \PDO::PARAM_INT);

        $q->execute();
    }

    public function delete($id)
    {
        $q = $this->dao->prepare('DELETE FROM comments WHERE id = :id');
        $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);

        $q->execute();
    }

    public function get($id)
    {
        $q = $this->dao->prepare('SELECT auteur, contenu, news, id FROM comments WHERE id = :id');
        $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);

        $q->execute();
        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

        return $q->fetch();
    }

    public function getListOf($news)
    {
        if (!ctype_digit($news)) {
            throw new  \InvalidArgumentException('L\'identifiant de la news doit être un nombre entier valide.');
        }

        $q = $this->dao->prepare('SELECT id, news, auteur, contenu, date FROM comments WHERE news = :news');
        $q->bindValue(':news', (int) $news, \PDO::PARAM_INT);
        $q->execute();

        $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');
        $comments = $q->fetchAll();

        foreach ($comments as $comment) {
            $comment->setDate(new \DateTime($comment->getDate()));
        }
        return $comments;
    }

    public function deleteFromNews($news)
    {
        $q = $this->dao->prepare('DELETE FROM comments WHERE news = :news');
        $q->bindValue(':news', (int) $news, \PDO::PARAM_INT);

        $q->execute();
    }
}
