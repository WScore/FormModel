<?php
/**
 * Created by PhpStorm.
 * User: asao
 * Date: 2019-03-20
 * Time: 10:12
 */

use PHPUnit\Framework\TestCase;
use WScore\FormModel\FormModel;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Validation\Validator;
use WScore\Validation\Filters\StringCases;
use WScore\Validation\Validators\Result;

class FormTypeTest extends TestCase
{
    public function testFormModelElement()
    {
        $fm = FormModel::create();
        $text = $fm->element(ElementInterface::TYPE_TEXT, 'name');
        $text->setAttributes([
            'class' => 'form-type',
            'style' => 'width:5em',
        ]);
        $text->setFilters([
            StringCases::class => [StringCases::TO_UPPER],
        ]);
        $text->isRequired();
        $html = $text->createHtml('test-me');
        $this->assertEquals(
            '<input type="text" class="form-type" style="width:5em" required="required">',
            $html->form()->toString()
        );

        $validator = $text->createValidation();
        $this->assertEquals(Validator::class, get_class($validator));
        $result = $validator->verify('my name');
        $this->assertEquals(Result::class, get_class($result));
        $this->assertEquals('MY NAME', $result->value());
    }
}
