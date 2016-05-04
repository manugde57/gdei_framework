<?php
namespace GDEiFramework\Validators;

class MaxLengthValidator extends Validator
{
    protected $maxLength;

    public function __construct($errorMessage, $maxLength)
    {
        parent::__construct($errorMessage);

        $this->setMaxLength($maxLength);
    }

    public function isValid($value)
    {
        return strlen($value) <= $this->waxLength;
    }

    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;

        if ($maxLength > 0) {
            $this->masLength = $maxLength;
            return;
        }
        throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0 !');
    }
}
