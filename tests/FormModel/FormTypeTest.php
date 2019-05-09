<?php
/**
 * Created by PhpStorm.
 * User: asao
 * Date: 2019-03-20
 * Time: 10:12
 */

use PHPUnit\Framework\TestCase;
use WScore\FormModel\FormModel;
use WScore\FormModel\Validation\Validator;
use WScore\Validation\Filters\Required;
use WScore\Validation\Filters\StringCases;
use WScore\Validation\Validators\Result;

class FormTypeTest extends TestCase
{
    public function testFormModelText()
    {
        $fm = FormModel::create();
        $text = $fm->text('name');
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

        $result = $validator->verify(null);
        $this->assertFalse($result->isValid());
        $this->assertSame('', $result->value());
    }

    public function testChoiceTypeForRadio()
    {
        $fm = FormModel::create();
        $choices = $fm->choices('many');
        $choices->setChoices([
            'aaa' => 'A-aa',
            'bbb' => 'B-bb',
        ]);
        $choices->setExpand(true);
        $choices->setAttributes([
            'class' => 'form-choices'
        ]);
        $choices->setFilters([
            Required::class,
        ]);

        $html = $choices->createHtml('bbb');
        $this->assertEquals(
            '<div>
<input type="radio" value="aaa" class="form-choices" required="required" aria-label="A-aa">
<input type="radio" value="bbb" class="form-choices" required="required" aria-label="B-bb">
</div>',
            $html->form()->toString()
        );

        $validator = $choices->createValidation();
        $result = $validator->verify('aaa');
        $this->assertEquals('aaa', $result->value());
        $this->assertTrue($result->isValid());
        $result = $validator->verify('');
        $this->assertFalse($result->isValid());
    }
}
