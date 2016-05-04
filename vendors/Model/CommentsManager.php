<?php
namespace Model;

use \GDEiFramework\Manager;
use \Entity\Comment;

abstract class CommentsManager extends Manager
{
    /**
     * Méthode permettant d'ajouter un commentaire
     * @param $comment Le commentaire à ajouter
     * @return void
     */
    abstract protected function add(Comment $comment);

    /**
     * Méthode permettant de modifier un commentaire
     * @param Comment $comment Le commentaire à modifier
     * @return void
     */
    abstract protected function modify(Comment $comment);

    /**
     * Méthode permettant de supprimer un commentaire
     * @param int $id ID du commentaire à supprimer
     * @return void
     */
    abstract public function delete($id);

    /**
     * Méthode permettant d'obtenir un commentaire spécifique
     * @param int $id L'identifiant du commentaire
     * @return Comment Le commentaire retrouné
     */
    abstract public function get($id);

    /**
     * Méthode permettante d'enregistrer un commentaire
     * @param $comment Le commentaire à enregistrer
     * @return void
     */
    public function save(Comment $comment)
    {
        if ($comment->isValid()) {
            $comment->isNew() ? $this->add($comment) : $this->modify($comment);
            return;
        }

        throw new \RuntimeException('Le commentiare doit être validé pour être enregistré.');
    }

    /**
     * Méthode permettant de récupéré une liste de commentaires
     * @param $news La news sr laquelle on veut récupérer les commentaires
     * @return array La liste des commentaires (type Comment)
     */
    abstract public function getListOf($news);

    /**
     * Méthode permettant de supprimer tous les commentaires d'une news supprimée
     * @param int $news La news de référence
     * @return void
     */
    abstract public function deleteFromNews($news);
}
