<?php
/**
 * Created by PhpStorm.
 * User: asao
 * Date: 2019-03-20
 * Time: 10:12
 */

use PHPUnit\Framework\TestCase;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\Element\TextType;
use WScore\FormModel\FormModel;
use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\Validation\Filters\Required;

class FormTypeTest extends TestCase
{
    public function testFormModelElement()
    {
        $fm = FormModel::create();
        $text = $fm->element(BaseElementInterface::TYPE_TEXT, 'name');
        $text->setAttributes([
            'class' => 'form-type',
            'style' => 'width:5em',
        ]);
        $text->setFilters([
            Required::class,
        ]);
        $html = $text->createHtml('test-me');
        $this->assertEquals('', $html->form()->toString());
    }
}
