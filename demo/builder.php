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
        ->add('language', ElementType::TYPE_CHOICE, [
            'label' => 'Written Language',
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
            'choices' => [
                'HARDCOVER' => 'Hard Cover',
                'PAPERBACK' => 'Paperback',
            ],
            'expand' => true,
        ])
        ->add('type', ElementType::TYPE_CHOICE, [
            'label' => 'Book Category',
            'choices' => [
                'FICTION' => 'Fiction',
                'NON_FICTION' => 'Non Fiction',
                'MANGA' => 'Manga',
            ],
            'expand' => true,
            'multiple' => true,
        ])
    ;

    return $book;
}

/**
 * @return FormModel
 */
function buildPublisher()
{
    $publisher = new FormModel(FormBuilder::create(), 'book');
    $publisher
        ->add('name', ElementType::TYPE_TEXT, [
            'label' => 'publisher name',
        ])
        ->add('editor', "URL", [
            'label' => 'Corporate URL',
            'required' => false,
        ]);

    return $publisher;
}