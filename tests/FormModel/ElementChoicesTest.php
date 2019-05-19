<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use WScore\FormModel\FormBuilder;
use WScore\Validation\Filters\Required;

class ElementChoicesTest extends TestCase
{
    public function testChoiceTypeForRadio()
    {
        $fm = FormBuilder::create();
        $choices = $fm->choices('many', 'Various Selections');
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
        $this->assertEquals('Various Selections', $html->label());
        $this->assertEquals(
            '<label><input type="radio" name="many" id="many_0" class="form-choices" required="required" value="aaa"> A-aa</label>
<label><input type="radio" name="many" id="many_1" class="form-choices" required="required" value="bbb" checked="checked"> B-bb</label>
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
        $fm = FormBuilder::create();
        $choices = $fm->choices('many');
        $choices->setChoices([
            'aaa' => 'A-aa',
            'bbb' => 'B-bb',
            'ccc' => 'C-cc',
        ]);
        $choices->setExpand(true);
        $choices->setMultiple(true);
        $choices->setAttributes([
            'class' => 'form-choices'
        ]);
        $choices->setRequired();

        $html = $choices->createHtml(['aaa', 'ccc']);
        $this->assertEquals(
            '<label><input type="checkbox" name="many[0]" id="many_0_" class="form-choices" required="required" value="aaa" checked="checked"> A-aa</label>
<label><input type="checkbox" name="many[1]" id="many_1_" class="form-choices" required="required" value="bbb"> B-bb</label>
<label><input type="checkbox" name="many[2]" id="many_2_" class="form-choices" required="required" value="ccc" checked="checked"> C-cc</label>
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
        $fm = FormBuilder::create();
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
<option value="bbb" selected>B-bb</option>
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

    public function testChoicesMultipleFilter()
    {
        $fm = FormBuilder::create();
        $choices = $fm->choices('many');
        $choices->setChoices([
            'aaa' => 'A-aa',
            'bbb' => 'B-bb',
        ]);
        $choices->setExpand(false);
        $choices->setMultiple([
            Required::class,
        ]);
        $validator = $choices->createValidation();
        $result = $validator->verify([]);
        $this->assertFalse($result->isValid());
    }
}
