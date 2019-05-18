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
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;
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
        /** @var Input $form */
        $form = $html['title']->form();
        $this->assertEquals('book[title]', $form->get('name'));
        $this->assertEquals('book_title_', $form->get('id'));
        $this->assertEquals('test-me', $form->get('value'));
        $this->assertEquals('required', $form->get('required'));

        /** @var Input $form */
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
