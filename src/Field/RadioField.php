<?php

namespace WonderWp\Component\Form\Field;

use WonderWp\Component\Form\FormValidator;
use WonderWp\Component\DependencyInjection\Container;
use WonderWp\Component\Form\Validation\Validator;
use function WonderWp\Functions\array_merge_recursive_distinct;

class RadioField extends FieldGroup implements OptionsFieldInterface
{
    /** @inheritdoc */
    public function __construct($name, $value = null, array $displayRules = [], array $validationRules = [])
    {
        parent::__construct($name, $value, $displayRules, $validationRules);

        if (!array_key_exists('class', $this->displayRules['wrapAttributes'])) {
            $this->displayRules['wrapAttributes']['class'] = [];
        }

        $this->displayRules['wrapAttributes']['class'][] = 'radio-group';
    }

    /**
     * @param array $passedGroupedDisplayRules
     * @param array $passedGroupedValidationRules
     *
     * @return static
     */
    public function generateRadios(array $passedGroupedDisplayRules = [], array $passedGroupedValidationRules = [])
    {
        $container = Container::getInstance();
        $name      = $this->getName();
        if (!empty($this->options)) {
            $i = 0;
            foreach ($this->options as $val => $label) {
                $optFieldName           = $name . '__' . $val . '';
                $defaultOptDisplayRules = [
                    'label'           => $label,
                    'labelInverted'   => true,
                    'inputAttributes' => [
                        'name'  => $name,
                        'id'    => $name . '__' . $val,
                        'value' => $val,
                    ],
                    'wrapAttributes'  => [
                        'class' => ['radio-wrap'],
                    ],
                ];
                if ($val == $this->value) {
                    $defaultOptDisplayRules['inputAttributes']['checked'] = '';
                }
                $passedOptDisplayRules = isset($passedGroupedDisplayRules[$val]) ? $passedGroupedDisplayRules[$val] : [];
                $optDisplayRules       = array_merge_recursive_distinct($defaultOptDisplayRules, $passedOptDisplayRules);

                $validationRules = [];
                if ($i === 0) {
                    /** @var FormValidator $formValidator */
                    $formValidator = $container->offsetGet('wwp.form.validator');
                    if ($formValidator::hasRule($this->getValidationRules(), 'NotEmpty')) {
                        $validationRules[] = Validator::notEmpty();
                    }
                }

                $optField = new InputField($optFieldName, isset($this->value[$val]) ? $this->value[$val] : null, $optDisplayRules, $validationRules);
                $optField->setType('radio');
                $this->addFieldToGroup($optField);
            }
        }

        return $this;
    }

    /** @inheritdoc */
    public function setValue($value)
    {
        parent::setValue($value);

        foreach ($this->group as $cbField) {
            /** @var CheckBoxField $cbField */
            $displayRules = $cbField->getDisplayRules();
            $cbValue      = !empty($displayRules['inputAttributes']['value']) ? $displayRules['inputAttributes']['value'] : null;

            if (!empty($cbValue) && isset($this->value[$cbValue])) {
                $cbField->setValue($this->value[$cbValue]);
            }

            if ($cbValue == $value) {
                $displayRules['inputAttributes']['checked'] = '';
                $cbField->setDisplayRules($displayRules);
            } elseif (array_key_exists('checked', $displayRules['inputAttributes'])) {
                unset($displayRules['inputAttributes']['checked']);
                $cbField->setDisplayRules($displayRules);
            }
        }

        return $this;
    }
}

