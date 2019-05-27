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

    $book->add('title', ElementType::TYPE_TEXT, [
        'label' => 'Book Title',
        'required' => true,
    ])
        ->add('published_at', ElementType::DATE, [
            'label' => 'Published At',
            'attributes' => [
                'style' => 'width: 12em;'
            ]
        ])
        ->add('type', ElementType::TYPE_CHOICE, [
            'label' => 'book type',
            'choices' => [
                'FICTION' => 'Fiction',
                'NON_FICTION' => 'Non Fiction',
                'MANGA' => 'Manga',
            ],
            'expand' => true,
        ])
    ;

    return $book;
}
