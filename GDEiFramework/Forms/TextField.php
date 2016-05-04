<?php
namespace GDEiFramework\Forms;

class TextField extends Field
{
    protected $cols;
    protected $rows;

    public function buildWidget()
    {
        $widget = '';

        if (!empty($this->errorMessage)) {
            $widget .= $this->errorMessage . '<br />';
        }

        $widget .= '<label>' . $this->getLabel() . '</label>';
        $widget .= '<textarea name="' . $this->getName() . '"';

        if (!empty($this->cols)) {
            $widget .= ' cols="' . $this->cols . '"';
        }

        if (!empty($this->rows)) {
            $widget .= ' rows="' . $this->rows . '"';
        }

        $widget .= '>';

        if (!empty($this->getValue())) {
            $widget .= $this->getValue();
        }

        $widget .= '</textarea>';
        return $widget;
    }

    public function setCols($cols)
    {
        $cols = (int) $cols;

        if ($cols > 0) {
            $this->cols = $cols;
        }
    }

    public function setRows($rows)
    {
        $rows = (int) $rows;

        if ($rows > 0) {
            $this->rows = $rows;
        }
    }
}
