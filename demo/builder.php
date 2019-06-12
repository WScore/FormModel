<?php

use WScore\FormModel\Element\ElementType;
use WScore\FormModel\FormBuilder;
use WScore\FormModel\FormModel;
use WScore\Validation\Filters\FilterEmptyValues;
use WScore\Validation\Filters\Required;

/**
 * @return FormModel
 */
function buildForm()
{
    $builder = FormBuilder::create();
    $book = $builder->formModel('book', [
            'label' => 'Book Information',
            'filters' => [
                FilterEmptyValues::class
            ]
        ])
        ->add('title', ElementType::TEXT, [
            'label' => 'Book Title',
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
            'expand' => true,
            'choices' => [
                'case1' => 'Case #1',
                'case2' => 'Case #2',
                'case3' => 'Case #3',
            ]
        ])
        ->add('abstract', ElementType::TEXTAREA, [
            'label' => 'Abstracts',
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
                'TEXT_BOOK' => 'Book',
                'MAGAZINE' => 'Magazine',
                'MANGA' => 'Manga',
            ],
            'expand' => true,
            'multiple' => true,
        ])
        ->addForm('publisher', buildPublisher($builder), [
            'label' => 'Publisher Information',
        ])
        ->addForm('authors', buildAuthor($builder), [
            'repeat' => 3,
            'label' => 'Author List',
            'filters' => [
                Required::class,
            ],
        ])
    ;

    return $book;
}

/**
 * @param FormBuilder $builder
 * @return FormModel
 */
function buildPublisher(FormBuilder $builder)
{
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

/**
 * @param FormBuilder $builder
 * @return FormModel
 */
function buildAuthor(FormBuilder $builder)
{
    $author = $builder->formModel('author', [
        'label' => 'author info',
    ]);
    $author
        ->add('name', ElementType::TEXT, [
            'label' => 'author name',
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
}