<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use WScore\FormModel\FormBuilder;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Type\DateType;
use WScore\Validator\Filters\StringCases;

class FormTypeTest extends TestCase
{
    public function testForm()
    {
        $fm = FormBuilder::create();
        $book = $fm->form('book', 'Book List');
        $book->add($fm->text('title')->setFilters([StringCases::class=>[StringCases::UC_WORDS]]));
        $book->add($fm->date('published_at'));

        $title = $book->get('title');
        $this->assertEquals('title', $title->getName());

        $html = $book->createHtml([
            'book' => [
                'title' => 'test-me',
                'published_at' => '2019-05-05',
            ]
        ]);
        $this->assertEquals('Book List', $html->label());
        $this->assertTrue($html->hasChildren());
        $this->assertEquals('<form method="post" name="book">', $html->form()->toString());
        /** @var HtmlFormInterface $titleHtml */
        $titleHtml = $html['title'];
        $this->assertEquals('title', $titleHtml->name());
        $this->assertEquals('<input type="text" name="book[title]" id="book_title_" value="test-me" required="required">', $titleHtml->form()->toString());
        $this->assertEquals('<input type="date" name="book[published_at]" id="book_published_at_" value="2019-05-05" required="required">', $html['published_at']->form()->toString());

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
