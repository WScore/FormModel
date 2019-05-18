<?php
/**
 * Created by PhpStorm.
 * User: asao
 * Date: 2019-03-20
 * Time: 10:12
 */

use PHPUnit\Framework\TestCase;
use WScore\FormModel\FormModel;
use WScore\Validation\Filters\Required;

class ElementChoicesTest extends TestCase
{
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
        $choices->setRequired();

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

    public function testChoicesMultipleFilter()
    {
        $fm = FormModel::create();
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
