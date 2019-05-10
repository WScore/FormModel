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
            '<input type="text" name="name" id="name" class="form-type" style="width:5em" required="required">',
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
            '<label><input type="radio" name="many" id="many_0" class="form-choices" required="required" value="aaa"> A-aa</label>
<label><input type="radio" name="many" id="many_1" class="form-choices" required="required" value="bbb"> B-bb</label>
',
            $html->form()->toString()
        );

        $validator = $choices->createValidation();
        $result = $validator->verify('aaa');
        $this->assertEquals('aaa', $result->value());
        $this->assertTrue($result->isValid());

        $result = $validator->verify('');
        $this->assertFalse($result->isValid());
    }


    public function testChoiceTypeForCheckbox()
    {
        $fm = FormModel::create();
        $choices = $fm->choices('many');
        $choices->setChoices([
            'aaa' => 'A-aa',
            'bbb' => 'B-bb',
        ]);
        $choices->setExpand(true);
        $choices->setMultiple(true);
        $choices->setAttributes([
            'class' => 'form-choices'
        ]);
        $choices->setFilters([
            Required::class,
        ]);

        $html = $choices->createHtml('bbb');
        $this->assertEquals(
            '<label><input type="checkbox" name="many[0]" id="many_0_" class="form-choices" required="required" value="aaa"> A-aa</label>
<label><input type="checkbox" name="many[1]" id="many_1_" class="form-choices" required="required" value="bbb"> B-bb</label>
',
            $html->form()->toString()
        );

        $validator = $choices->createValidation();
        $result = $validator->verify(['aaa']);
        $this->assertEquals(['aaa'], $result->value());
        $this->assertTrue($result->isValid());

        $result = $validator->verify([]);
        $this->assertFalse($result->isValid());
    }

    public function testSelect()
    {
        $fm = FormModel::create();
        $choices = $fm->choices('many');
        $choices->setChoices([
            'aaa' => 'A-aa',
            'bbb' => 'B-bb',
        ]);
        $choices->setExpand(false);
        $choices->setAttributes([
            'class' => 'form-choices'
        ]);
        $choices->setFilters([
            Required::class,
        ]);

        $html = $choices->createHtml('bbb');
        $this->assertEquals(
            '<select name="many" id="many" class="form-choices" required="required">
<option value="aaa">A-aa</option>
<option value="bbb">B-bb</option>
</select>',
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
