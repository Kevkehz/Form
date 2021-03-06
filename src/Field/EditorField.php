<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 08/09/2017
 * Time: 10:39
 */

namespace WonderWp\Component\Form\Field;

class EditorField extends AbstractField
{
    public function __construct($name, $value = null, array $displayRules = [], array $validationRules = [])
    {
        $this->tag = 'div';
        ob_start();
        wp_editor(stripslashes($value), $name);
        $value = ob_get_contents();
        ob_end_clean();

        //Added the -editor suffix here to differentiate the div that is going to be generated by the view vs the one that is going to be generated by WordPress via the wp_editor function
        return parent::__construct($name . '-editor', $value, $displayRules, $validationRules);
    }

    /** @inheritdoc */
    public function computeValidationRules(array $passedRules)
    {
        /**
         * Why no validation rules on purpose?
         * This is a bit special for several reasons:
         * - We work with a div tag, which doesn't accept attributes such as required or maxlength
         * - we work with the wp_editor function, which unfortunately doesn't accept our own validation rules
         * Thus they should be handled elsewhere
         */

        return $this;
    }

}
