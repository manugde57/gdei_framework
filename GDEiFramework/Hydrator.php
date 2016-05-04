<?php
namespace GdeiFramework;

trait Hydrator
{
    /**
     * Méthode permettant l'hydratation d'un objet
     * @param  array $data Tableau de donnée à hydrater
     * @return void
     */
    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucFirst($key);

            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }
}
