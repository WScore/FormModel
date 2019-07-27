<?php
declare(strict_types=1);

use WScore\FormModel\FormBuilder;
use WScore\FormModel\FormModel;
use WScore\FormModel\Type\CheckboxType;
use WScore\FormModel\Type\ChoiceType;
use WScore\FormModel\Type\DateTimeType;
use WScore\FormModel\Type\DateType;
use WScore\FormModel\Type\EmailType;
use WScore\FormModel\Type\HiddenType;
use WScore\FormModel\Type\MonthType;
use WScore\FormModel\Type\PasswordType;
use WScore\FormModel\Type\RadioType;
use WScore\FormModel\Type\TelType;
use WScore\FormModel\Type\TextAreaType;
use WScore\FormModel\Type\TextType;
use WScore\FormModel\Type\UrlType;
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
        ->add('title', TextType::class, [
            'label' => 'Book Title',
            'message' => 'a cool title is required!',
        ])
        ->add('hidden', HiddenType::class, [
            'label' => 'Hide-me',
            'attributes' => [
                'value' => 'hidden-val',
            ],
        ])
        ->add('million', CheckboxType::class, [
            'label' => 'Million Seller',
            'value' => 'MILLION',
            'message' => 'always aim for a million!',
        ])
        ->add('checked', RadioType::class, [
            'label' => 'Check Me',
            'value' => 'RADIO',
            'message' => 'always check me!',
        ])
        ->add('cases', ChoiceType::class, [
            'label' => 'Various Cases',
            'expand' => true,
            'choices' => [
                'case1' => 'Case #1',
                'case2' => 'Case #2',
                'case3' => 'Case #3',
            ],
            'message' => 'check the free located radio buttons!',
        ])
        ->add('abstract', TextAreaType::class, [
            'label' => 'Abstracts',
            'attributes' => [
                'style' => 'height: 5em;',
            ],
            'message' => 'good summary is nice!',
        ])
        ->add('published_at', DateType::class, [
            'label' => 'Published At',
            'required' => false,
            'attributes' => [
                'style' => 'width: 12em;'
            ],
        ])
        ->add('published_ym', MonthType::class, [
            'label' => 'Published Year/Month',
            'required' => false,
            'attributes' => [
                'style' => 'width: 12em;'
            ],
        ])
        ->add('updated_at', DateTimeType::class, [
            'label' => 'Updated date/time',
            'required' => false,
            'attributes' => [
                'style' => 'width: 16em;'
            ],
        ])
        ->add('isbn_code', TextType::class, [
            'label' => 'ISBN Code',
            'attributes' => [
                'style' => 'width: 16em;'
            ]
        ])
        ->add('secret_code', PasswordType::class, [
            'label' => 'Secret Code',
            'attributes' => [
                'style' => 'width: 12em;'
            ]
        ])
        ->add('language', ChoiceType::class, [
            'label' => 'Language',
            'placeholder' => 'select a language...',
            'choices' => [
                'zh' => 'Chinese',
                'en' => 'English',
                'ja' => 'Japanese',
            ],
            'message' => 'know your tongue!',
        ])
        ->add('format', ChoiceType::class, [
            'label' => 'Format Type',
            'placeholder' => 'select a type...',
            'choices' => [
                'HARDCOVER' => 'Hard Cover',
                'PAPERBACK' => 'Paperback',
            ],
            'expand' => true,
            'message' => 'format is missing!',
        ])
        ->add('type', ChoiceType::class, [
            'label' => 'Book Category',
            'choices' => [
                'TEXT_BOOK' => 'Book',
                'MAGAZINE' => 'Magazine',
                'MANGA' => 'Manga',
            ],
            'expand' => true,
            'multiple' => true,
            'message' => 'category missing!',
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
        ->add('name', TextType::class, [
            'label' => 'publisher name',
        ])
        ->add('url', UrlType::class, [
            'label' => 'Corporate URL',
            'required' => false,
        ])
        ->add('email', EmailType::class, [
        'label' => 'Contact Email',
        ])
        ->add('tel', TelType::class, [
            'label' => 'Telephone',
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
        ->add('name', TextType::class, [
            'label' => 'author name',
            'message' => 'who is it?',
        ])
        ->add('type', ChoiceType::class, [
            'label' => 'type',
            'placeholder' => 'select a type...',
            'choices' => [
                'AUTHOR' => 'Author',
                'STORY' => 'Story',
                'ILLUSTRATION' => 'Illustration',
            ],
            'message' => 'what they do?',
        ]);
    return $author;
}