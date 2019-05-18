<?php
/**
 * Created by PhpStorm.
 * User: asao
 * Date: 2019-03-20
 * Time: 10:12
 */

use PHPUnit\Framework\TestCase;
use WScore\FormModel\FormModel;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Validation\Validator;
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

    public function testForm()
    {
        $fm = FormModel::create();
        $book = $fm->form('book');
        $book->add($fm->text('title')->setFilters([StringCases::class=>[StringCases::UC_WORDS]]));
        $book->add($fm->element('date', 'published_at'));

        $title = $book->get('title');
        $this->assertEquals('title', $title->getName());

        $html = $book->createHtml();
        $this->assertTrue($html->hasChildren());
        $this->assertEquals('<form method="post" name="book">', $html->form()->toString());
        /** @var HtmlFormInterface $titleHtml */
        $titleHtml = $html['title'];
        $this->assertEquals('title', $titleHtml->name());
        $this->assertEquals('<input type="text" name="book[title]" id="book_title_" required="required">', $titleHtml->form()->toString());
        $this->assertEquals('<input type="date" name="book[published_at]" id="book_published_at_" required="required">', $html['published_at']->form()->toString());

        $validation = $book->createValidation();
        $result = $validation->verify([
            'title' => 'testing form model',
            'published_at' => '2019-05-17',
        ]);
        $this->assertTrue($result->isValid());
        $this->assertEquals('Testing Form Model', $result->getChild('title')->value());
        $this->assertEquals('2019.05.17', $result->getChild('published_at')->value()->format('Y.m.d'));
    }
}
