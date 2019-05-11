<?php
/**
 * Created by PhpStorm.
 * User: asao
 * Date: 2019-03-20
 * Time: 10:12
 */

use PHPUnit\Framework\TestCase;
use WScore\FormModel\FormModel;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Validation\Filters\StringCases;

class NestedFormTest extends TestCase
{
    /**
     * @var FormElementInterface
     */
    private $book;

    public function setUp(): void
    {
        $fm = FormModel::create();
        $book = $fm->form('book');
        $book->add(
            $fm->text('title')
                ->setFilters([
                    StringCases::class=>[StringCases::UC_WORDS]
                ])
        );
        $book->addForm(
            $fm->form('publisher')
                ->add($fm->text('name'))
        );
        $this->book = $book;
    }

    public function testTitle()
    {
        $fm = FormModel::create();
        $book = $fm->form('book');
        $book->add($fm->text('title')->setFilters([StringCases::class => [StringCases::UC_WORDS]]));

        $title = $book->get('title');
        $this->assertEquals('title', $title->getName());
        $this->assertEquals('book[title]', $title->getFullName());
    }

    public function testNestedForm()
    {
        $book = $this->book;
        $publisher = $book->get('publisher');
        $name = $publisher->get('name');
        $this->assertEquals('name', $name->getName());
        $this->assertEquals('book[publisher][name]', $name->getFullName());
    }

    public function testNestedHtml()
    {
        $html = $this->book->createHtml();
        $this->assertEquals('<input type="text" name="book[title]" id="book_title_" required="required">', $html['title']->form()->toString());
        $this->assertEquals('<input type="text" name="book[publisher][name]" id="book_publisher__name_" required="required">', $html['publisher']['name']->form()->toString());
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
