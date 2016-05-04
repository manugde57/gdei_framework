<?php
namespace Model;

use \Entity\News;

class NewsManagerPDO extends NewsManager
{
    public function getList($debut = -1, $limite = -1)
    {
        $sql = "SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news ORDER BY id DESC";

        if ($debut != -1 || $limite != -1) {
            $sql .= ' LIMIT ' . (int) $limite . ' OFFSET ' . (int) $debut;
        }

        $requete = $this->dao->query($sql);
        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

        $listeNews = $requete->fetchAll();

        foreach ($listeNews as $news) {
            $news->setDateAjout(new \DateTime($news->getDateAjout()));
            $news->setDateModif(new \DateTime($news->getDateModif()));
        }

        $requete->closeCursor();

        return $listeNews;
    }

    public function getUnique($id)
    {
        $requete = $this->dao->prepare('SELECT id, auteur, titre, contenu, dateAjout, dateModif FROM news WHERE id = :id');
        $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();

        $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');

        if ($news = $requete->fetch()) {
            $news->setDateAjout(new \DateTime($news->getDateAjout()));
            $news->setDateModif(new \DateTime($news->getDateModif()));
        }

        return $news;
    }

    public function count()
    {
        return $this->dao->query('SELECT COUNT(*) FROM news')->fetchColumn();
    }

    protected function add(News $news)
    {
        $requete = $this->dao->prepare('INSERT INTO news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');
        $requete->bindValue(':auteur', $news->getAuteur());
        $requete->bindValue(':titre', $news->getTitre());
        $requete->bindValue(':contenu', $news->getContenu());

        $requete->execute();
    }

    protected function modify(News $news)
    {
        $requete = $this->dao->prepare('UPDATE news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id = :id');
        $requete->bindValue(':id', (int) $news->getId(), \PDO::PARAM_INT);
        $requete->bindValue(':auteur', $news->getAuteur());
        $requete->bindValue(':titre', $news->getTitre());
        $requete->bindValue(':contenu', $news->getContenu());

        $requete->execute();
    }

    public function delete($id)
    {
        $requete = $this->dao->prepare('DELETE FROM news WHERE id = :id');
        $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $requete->execute();
    }
}
