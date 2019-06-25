<?php
declare(strict_types=1);

namespace tests\FormModel;

use WScore\FormModel\Element\ElementType;
use WScore\FormModel\FormBuilder;
use WScore\FormModel\FormModel;
use WScore\Validation\Filters\FilterEmptyValues;
use WScore\Validation\Filters\Required;

class RealCases
{
    /**
     * @var FormBuilder
     */
    private $builder;

    public function __construct()
    {
        $this->builder = FormBuilder::create();
    }

    public static function forge(): self
    {
        return new self();
    }

    public function build(): FormModel
    {
        $builder = $this->builder;
        $book = $builder->formModel('book', [
            'label' => 'Book Information',
            'filters' => [
                FilterEmptyValues::class
            ]
        ])
            ->add('title', ElementType::TEXT, [
                'label' => 'Book Title',
                'message' => 'enter title here',
            ])
            ->add('million', ElementType::CHECKBOX, [
                'label' => 'Million Seller',
                'value' => 'MILLION',
            ])
            ->add('checked', ElementType::RADIO, [
                'label' => 'Check Me',
                'value' => 'RADIO',
            ])
            ->add('cases', ElementType::CHOICE_TYPE, [
                'label' => 'Various Cases',
                'message' => 'check some',
                'expand' => true,
                'choices' => [
                    'case1' => 'Case #1',
                    'case2' => 'Case #2',
                    'case3' => 'Case #3',
                ]
            ])
            ->add('abstract', ElementType::TEXTAREA, [
                'label' => 'Abstracts',
                'message' => 'summary',
                'attributes' => [
                    'style' => 'height: 5em;',
                ]
            ])
            ->add('published_at', ElementType::DATE, [
                'label' => 'Published At',
                'required' => false,
                'attributes' => [
                    'style' => 'width: 12em;'
                ]
            ])
            ->add('isbn_code', ElementType::TEXT, [
                'label' => 'ISBN Code',
                'attributes' => [
                    'style' => 'width: 16em;'
                ]
            ])
            ->add('language', ElementType::CHOICE_TYPE, [
                'label' => 'Language',
                'placeholder' => 'select a language...',
                'choices' => [
                    'zh' => 'Chinese',
                    'en' => 'English',
                    'ja' => 'Japanese',
                ],
            ])
            ->add('format', ElementType::CHOICE_TYPE, [
                'label' => 'Format Type',
                'placeholder' => 'select a type...',
                'choices' => [
                    'HARDCOVER' => 'Hard Cover',
                    'PAPERBACK' => 'Paperback',
                ],
                'expand' => true,
            ])
            ->add('type', ElementType::CHOICE_TYPE, [
                'label' => 'Book Category',
                'choices' => [
                    'T' => 'Book',
                    'M' => 'Magazine',
                    'C' => 'Comic',
                ],
                'replace' => true,
                'expand' => true,
                'multiple' => true,
            ])
            ->addForm('publisher', $this->buildPublisher(), [
                'label' => 'Publisher Information',
            ])
            ->addForm('authors', $this->buildAuthor(), [
                'repeat' => 3,
                'label' => 'Author List',
                'filters' => [
                    Required::class,
                ],
            ])
        ;

        return $book;
    }

    private function buildPublisher(): FormModel
    {
        $builder = $this->builder;
        $publisher = $builder->formModel('publisher');
        $publisher
            ->add('name', ElementType::TEXT, [
                'label' => 'publisher name',
            ])
            ->add('url', "URL", [
                'label' => 'Corporate URL',
                'required' => false,
            ]);

        return $publisher;
    }

    private function buildAuthor(): FormModel
    {
        $builder = $this->builder;
        $author = $builder->formModel('author', [
            'label' => 'author info',
        ]);
        $author
            ->add('name', ElementType::TEXT, [
                'label' => 'author name',
                'message' => 'names here',
            ])
            ->add('type', ElementType::CHOICE_TYPE, [
                'label' => 'type',
                'placeholder' => 'select a type...',
                'choices' => [
                    'AUTHOR' => 'Author',
                    'STORY' => 'Story',
                    'ILLUSTRATION' => 'Illustration',
                ],
            ]);
        return $author;
    }}
