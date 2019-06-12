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
}
