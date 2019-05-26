<?php
declare(strict_types=1);

namespace tests\FormModel;

use PHPUnit\Framework\TestCase;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\FormBuilder;
use WScore\FormModel\FormModel;

class FormModelTest extends TestCase
{
    public function testFormModel()
    {
        $builder = FormBuilder::create();
        $form = new FormModel($builder, 'test-form');
        $form->add('name', ElementType::TYPE_TEXT, [
            'label' => 'User Name',
        ]);
        $text = $form->get('name');
        $this->assertEquals('name', $text->getName());
        $this->assertEquals('User Name', $text->getLabel());
    }
}
