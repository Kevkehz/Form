<?php

namespace WonderWp\Component\Form\Field;

class InputField extends AbstractField
{
    /** @inheritdoc */
    public function __construct($name, $value = null, array $displayRules = [], array $validationRules = [])
    {
        parent::__construct($name, $value, $displayRules, $validationRules);

        $this->tag  = 'input';
        $this->type = 'text';
    }
}
