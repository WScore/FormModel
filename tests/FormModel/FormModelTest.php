<?php
declare(strict_types=1);

namespace tests\FormModel;

use PHPUnit\Framework\TestCase;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\FormBuilder;
use WScore\FormModel\FormModel;
use WScore\FormModel\ToString\ViewModel;

class FormModelTest extends TestCase
{
    public function testFormModel()
    {
        $builder = FormBuilder::create();
        $form = new FormModel($builder, 'test-form');
        $form->add('name', ElementType::TEXT, [
            'label' => 'User Name',
        ]);
        $text = $form->get('name');
        $this->assertEquals('name', $text->getName());
        $this->assertEquals('User Name', $text->getLabel());
    }

    public function testChoices()
    {
        $builder = FormBuilder::create();
        $form = new FormModel($builder, 'book');
        $form->add('type', ElementType::CHOICE_TYPE, [
            'label' => 'Book Type',
            'choices' => [
                'fiction' => 'Fiction',
                'non-fiction' => 'Non Fiction',
                'manga' => 'Manga',
            ],
            'expand' => true,
        ]);
        $type = $form->get('type');
        $this->assertEquals('type', $type->getName());
        $this->assertEquals('Book Type', $type->getLabel());

        $view = $form->createView();
        $typeHtml = $view['type'];
        $this->assertTrue($typeHtml instanceof ViewModel);
        $this->assertEquals('<div class="form-check">
<input type="radio" name="book[type]" id="book[type]_0" required="required" value="fiction" class="form-check-input">
<label class="form-check-label" for="book[type]_0">Fiction</label>
</div><div class="form-check">
<input type="radio" name="book[type]" id="book[type]_1" required="required" value="non-fiction" class="form-check-input">
<label class="form-check-label" for="book[type]_1">Non Fiction</label>
</div><div class="form-check">
<input type="radio" name="book[type]" id="book[type]_2" required="required" value="manga" class="form-check-input">
<label class="form-check-label" for="book[type]_2">Manga</label>
</div>', $typeHtml->widget());
    }
}
