<?php

namespace WonderWp\Component\Form;

use PHPUnit\Framework\TestCase;

class FormGroupTest extends TestCase
{
    /**
     * @var FormGroup
     */
    private $formGroup;

    public function setUp()
    {
        $this->formGroup = new FormGroup('testName', 'testTitle');
    }

    public function testConstructorShouldReturnFormGroupInstance()
    {
        $this->assertInstanceOf(FormGroup::class, $this->formGroup);
    }

    public function testSetNameShouldSet()
    {
        $name = 'testName';
        $this->formGroup->setName($name);
        $this->assertEquals($name, $this->formGroup->getName());
    }

    public function testSetTitleShouldSet()
    {
        $title = 'testTitle';
        $this->formGroup->setTitle($title);
        $this->assertEquals($title, $this->formGroup->getTitle());
    }

    public function testSetDisplayRulesShouldSet()
    {
        $displayRules = ['class' => 'test'];
        $this->formGroup->setDisplayRules($displayRules);
        $this->assertEquals($displayRules, $this->formGroup->getDisplayRules());
    }
}
