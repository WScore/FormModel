<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\FormBuilder;
use WScore\Validation\Filters\StringCases;

class NestedFormTest extends TestCase
{
    /**
     * @var ElementInterface
     */
    private $book;

    public function setUp(): void
    {
        $fm = FormBuilder::create();
        $book = $fm->form('book');
        $book->add(
            $fm->text('title')
                ->setFilters([
                    StringCases::class=>[StringCases::UC_WORDS]
                ])
        );
        $book->add(
            $fm->form('publisher')
                ->add($fm->text('name'))
        );
        $this->book = $book;
    }

    public function testTitle()
    {
        $fm = FormBuilder::create();
        $book = $fm->form('book');
        $book->add($fm->text('title')->setFilters([StringCases::class => [StringCases::UC_WORDS]]));

        $title = $book->get('title');
        $this->assertEquals('title', $title->getName());
    }

    public function testNestedForm()
    {
        $book = $this->book;
        $publisher = $book->get('publisher');
        $name = $publisher->get('name');
        $this->assertEquals('name', $name->getName());
    }

    public function testNestedHtml()
    {
        $html = $this->book->createHtml([
            'book' => [
                'title' => 'test-me',
                'publisher' => [
                    'name' => 'pub-test',
                ]
            ]
        ]);
        $form = $html['title']->form();
        $this->assertEquals('book[title]', $form->get('name'));
        $this->assertEquals('book_title_', $form->get('id'));
        $this->assertEquals('test-me', $form->get('value'));
        $this->assertEquals('required', $form->get('required'));

        $form = $html['publisher']['name']->form();
        $this->assertEquals('book[publisher][name]', $form->get('name'));
        $this->assertEquals('book_publisher__name_', $form->get('id'));
        $this->assertEquals('pub-test', $form->get('value'));
        $this->assertEquals('required', $form->get('required'));
    }


    public function testNestedValidation()
    {
        $validation = $this->book->createValidation();
        $result = $validation->verify([
            'title' => 'testing form model',
            'publisher' => [
                'name' => 'packagist inc.'
            ]
        ]);
        $this->assertTrue($result->isValid());
        $this->assertEquals('Testing Form Model', $result->getChild('title')->value());
        $this->assertEquals('packagist inc.', $result->getChild('publisher')->getChild('name')->value());
    }
}
