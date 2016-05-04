<?php
namespace GDEiFramework\Forms;

abstract class Field
{
    use \GDEiFramework\Hydrator;

    protected $errorMessage;
    protected $field;
    protected $value;
    protected $name;
    protected $validators = [];

    public function __construct(array $options = [])
    {
        if (!empty($options)) {
            $this->hydrate($options);
        }
    }

    abstract public function buildWidget();

    public function isValid()
    {
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this->value)) {
                $this->errorMessage = $validator->getErrorMessage();
                return false;
            }
        }
        return true;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return htmlspecialchars($this->value);
    }

    public function getValidators()
    {
        return $this->validators;
    }

    public function setLabel($label)
    {
        if (is_string($label)) {
            $this->label = $label;
        }
    }

    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }
    }

    public function setValue($value)
    {
        if (is_string($value)) {
            $this->value = $value;
        }
    }

    public function setValidators(array $validators)
    {
        foreach ($validators as $validator) {
            if ($validator instanceof Validator && !in_array($validator, $this->validators)) {
                $this->validators[] = $validator;
            }
        }
    }
}
