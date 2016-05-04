<?php
namespace GDEiFramework\Forms;

class StringField extends Field
{
    protected $maxLength;

    public function buildWidget()
    {
        $widget = '';

        if (!empty($this->errorMessage)) {
            $widget .= $this->errorMessage.'<br />';
        }

        $widget .= '<label>' . $this->getLabel() . '</label>';
        $widget .= '<input type="texte" name="' . $this->getName() . '" ';

        if (!empty($this->getValue())) {
            $widget .= 'value="' . $this->getValue() . '" ';
        }

        if (!empty($this->maxLength)) {
            $widget .= 'maxlength="' . $this->maxLength . '"';
        }

        $widget .= ' />';
        return $widget;
    }

    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;

        if ($maxLength > 0) {
            $this->maxLength = $maxLength;
            return;
        }
        throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0 !');
    }
}
