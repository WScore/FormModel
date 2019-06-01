<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use WScore\FormModel\FormBuilder;
use WScore\FormModel\Validation\Validator;
use WScore\Validation\Filters\StringCases;
use WScore\Validation\Validators\Result;

class InputTypeTest extends TestCase
{
    public function testFormModelText()
    {
        $fm = FormBuilder::create();
        $text = $fm->text('name', 'User Name');
        $text->setAttributes([
            'class' => 'form-type',
            'style' => 'width:5em',
        ]);
        $text->setFilters([
            StringCases::class => [StringCases::TO_UPPER],
        ]);
        $html = $text->createHtml('test-me');
        $this->assertEquals(
            '<input type="text" name="name" id="name" value="test-me" class="form-type" style="width:5em" required="required">',
            $html->form()->toString()
        );
        $this->assertEquals('User Name', $html->label());

        $validator = $text->createValidation();
        $this->assertEquals(Validator::class, get_class($validator));
        $result = $validator->verify('my name');
        $this->assertEquals(Result::class, get_class($result));
        $this->assertEquals('MY NAME', $result->value());

        $result = $validator->verify(null);
        $this->assertFalse($result->isValid());
        $this->assertSame('', $result->value());
    }
}
