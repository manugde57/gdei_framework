<?php
namespace GDEiFramework\Validators;

class NotNullValidator extends Validator
{
    public function isValid($value)
    {
        return $value != '';
    }
}
