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
                'comic' => 'Comic',
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
<input type="radio" name="book[type]" id="book_type__fiction" value="fiction" required="required" class="form-check-input">
<label class="form-check-label" for="book_type__fiction">Fiction</label>
</div><div class="form-check">
<input type="radio" name="book[type]" id="book_type__non-fiction" value="non-fiction" required="required" class="form-check-input">
<label class="form-check-label" for="book_type__non-fiction">Non Fiction</label>
</div><div class="form-check">
<input type="radio" name="book[type]" id="book_type__comic" value="comic" required="required" class="form-check-input">
<label class="form-check-label" for="book_type__comic">Comic</label>
</div>', $typeHtml->widget());
    }
}
