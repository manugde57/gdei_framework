<?php
namespace GDEiFramework;

class Entity implements \ArrayAccess
{
    use Hydrator;

    protected $erreurs = [];
    protected $id;

    public function __construct(array $donnees = [])
    {
        if (!empty($donnees)) {
            $this->hydrate($donnees);
        }
    }

    public function isNew()
    {
        return empty($this->id);
    }

    public function getErreurs()
    {
        return $this->erreurs;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function offsetGet($var)
    {
        if (isset($this->$var) && is_callable([$this, $var])) {
            return $this->$var();
        }
    }

    public function offsetSet($var, $value)
    {
        $methode = 'set' . ucfirst($var);

        if (isset($this->$var) && is_callable([$this, $var])) {
            $this->$var = $value;
        }
    }

    public function offsetExists($var)
    {
        return isset($this->$var) && is_callable([$this, $var]);
    }

    public function offsetUnset($var)
    {
        throw new \Exception('Impossible de supprimer une quelconque valeur.');
    }
}
