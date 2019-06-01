<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use WScore\FormModel\Element\FormElementInterface;
use WScore\FormModel\FormBuilder;
use WScore\Validation\Filters\StringCases;

class RepeatedFormTest extends TestCase
{
    /**
     * @var FormElementInterface
     */
    private $book;

    public function setUp(): void
    {
        $fm = FormBuilder::create();
        $author = $fm->form('author', 'Authors')
            ->add(
                $fm->text('name', 'Author Name')
                    ->setFilters([StringCases::class => [StringCases::UC_WORDS]])
            );
        $book = $fm->form('book')
            ->add($fm->text('title', 'Title')
                ->setFilters([StringCases::class => [StringCases::UC_WORDS]])
            )
            ->addRepeatedForm(1, $author);
        $this->book = $book;
    }

    public function testRepeatedForm()
    {
        $book = $this->book;
        $author = $book->get('author');
        $name = $author->get('name');
        $this->assertEquals('name', $name->getName());
        $this->assertEquals('Author Name', $name->getLabel());
    }

    public function testRepeatedHtml()
    {
        $html = $this->book->createHtml([
            'book' => [
                'title' => 'test-me',
                'author' => [
                    ['name' => 'auth zero',],
                    ['name' => 'auth one',],
                ]
            ]
        ]);
        $form = $html['title']->form();
        $this->assertEquals('book[title]', $form->get('name'));
        $this->assertEquals('book_title_', $form->get('id'));
        $this->assertEquals('test-me', $form->get('value'));
        $this->assertEquals('required', $form->get('required'));

        $form = $html['author'][0]['name']->form();
        $this->assertEquals('book[author][0][name]', $form->get('name'));
        $this->assertEquals('book_author__0__name_', $form->get('id'));
        $this->assertEquals('auth zero', $form->get('value'));
        $this->assertEquals('required', $form->get('required'));

        $form = $html['author'][2]['name']->form();
        $this->assertEquals('book[author][2][name]', $form->get('name'));
    }


    public function testNestedValidation()
    {
        $validation = $this->book->createValidation();
        $result = $validation->verify([
                'title' => 'testing repeated form',
                'author' => [
                    ['name' => 'auth zero',],
                    ['name' => 'auth one',],
                ]
            ]
        );
        $this->assertTrue($result->isValid());
        $this->assertEquals('Testing Repeated Form', $result->getChild('title')->value());
        $this->assertEquals('Auth Zero', $result->getChild('author')->getChild(0)->getChild('name')->value());
        $this->assertEquals('Auth One', $result->getChild('author')->getChild(1)->getChild('name')->value());
    }
}
