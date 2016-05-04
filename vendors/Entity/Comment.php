<?php
namespace Entity;

use \GDEiFramework\Entity;

class Comment extends Entity
{
    protected $news;
    protected $auteur;
    protected $contenu;
    protected $date;

    const AUTEUR_INVALIDE = 1;
    const CONTENU_INVALIDE = 2;

    public function isValid()
    {
        return !(empty($this->auteur) || empty($this->contenu));
    }

    public function setNews($news)
    {
        $this->news = (int) $news;
    }

    public function setAuteur($auteur)
    {
        if (!is_string($auteur) || empty($auteur)) {
            $this->erreurs[] = self::AUTEUR_INVALIDE;
        }
        $this->auteur = $auteur;
    }

    public function setContenu($contenu)
    {
        if (!is_string($contenu) || empty($contenu)) {
            $this->erreurs[] = self::CONTENU_INVALIDE;
        }
        $this->contenu = $contenu;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function getNews()
    {
        return $this->news;
    }

    public function getAuteur()
    {
        return $this->auteur;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function getDate()
    {
        return $this->date;
    }
}
