<?php

use WScore\FormModel\Element\ElementType;
use WScore\FormModel\FormBuilder;
use WScore\FormModel\FormModel;

/**
 * @return FormModel
 */
function buildForm()
{
    $book = new FormModel(FormBuilder::create(), 'book');

    $book
        ->add('title', ElementType::TYPE_TEXT, [
            'label' => 'Book Title',
        ])
        ->add('published_at', ElementType::DATE, [
            'label' => 'Published At',
            'required' => false,
            'attributes' => [
                'style' => 'width: 12em;'
            ]
        ])
        ->add('isbn_code', ElementType::TYPE_TEXT, [
            'label' => 'ISBN Code',
            'attributes' => [
                'style' => 'width: 16em;'
            ]
        ])
        ->add('language', ElementType::TYPE_CHOICE, [
            'label' => 'Written Language',
            'placeholder' => 'select a language',
            'choices' => [
                'zh' => 'Chinese',
                'en' => 'English',
                'ja' => 'Japanese',
            ],
# todo: implement placeholder for select.
#            'placeholder' => 'select a language',
            ])
        ->add('format', ElementType::TYPE_CHOICE, [
            'label' => 'Format Type',
            'placeholder' => 'select a type',
            'choices' => [
                'HARDCOVER' => 'Hard Cover',
                'PAPERBACK' => 'Paperback',
            ],
            'expand' => true,
        ])
        ->add('type', ElementType::TYPE_CHOICE, [
            'label' => 'Book Category',
            'choices' => [
                'TEXT_BOOK' => 'Book',
                'MAGAZINE' => 'Magazine',
                'MANGA' => 'Manga',
            ],
            'expand' => true,
            'multiple' => true,
        ])
        ->addForm('publisher', buildPublisher())
        ->addForm('authors', buildAuthor(), [
            'repeat' => 3
        ])
    ;

    return $book;
}

/**
 * @return FormModel
 */
function buildPublisher()
{
    $publisher = new FormModel(FormBuilder::create(), 'publisher');
    $publisher
        ->add('name', ElementType::TYPE_TEXT, [
            'label' => 'publisher name',
        ])
        ->add('url', "URL", [
            'label' => 'Corporate URL',
            'required' => false,
        ]);

    return $publisher;
}

/**
 * @return FormModel
 */
function buildAuthor()
{
    $author = new FormModel(FormBuilder::create(), 'author');
    $author
        ->add('name', ElementType::TYPE_TEXT, [
            'label' => 'author name',
        ])
        ->add('type', ElementType::TYPE_CHOICE, [
            'label' => 'type',
            'placeholder' => 'select a type',
            'choices' => [
                'AUTHOR' => 'Author',
                'STORY' => 'Story',
                'ILLUSTRATION' => 'Illustration',
            ],
        ]);
    return $author;
}