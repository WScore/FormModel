FormModel
=========

a framework agnostic component for building HTML forms and validations. 

works for; 

- various input types, such as date, textarea, choices,
- incorporates another form, 
- incorporates one-to-many forms, and 
- defaults to output html forms for `Bootstrap 4`. 

> inspired by `Symfony/form` component. 

### Installation

t.b.w.

### Demo

clone this repository, 

```
git clone https://github.com/asaokamei/FormModel
cd FormModel
composer install
```

run the demo script, 

```
cd demo
php -S localhost:8000
```

then, browse the above url. 

How To
------

### Set Up FormModel 

create a form model using `FormBuilder`. 

```php
use WScore\FormModel\FormBuilder;

$builder = FormBuilder::create();
$book = $builder->formModel('book', [
        'label' => 'Book Information',
    ]);
```

### Add Elements

add elements for the form model, `$book`. 

```php
use WScore\FormModel\Element\ElementType;

$book
    ->add('title', ElementType::TEXT, [
        'label' => 'Book Title',
    ])
    ->add('abstract', ElementType::TEXTAREA, [
        'label' => 'Abstracts',
        'attributes' => [
            'style' => 'height: 5em;',
        ]
    ]);
```

### Show HTML Form

to show HTML forms, create a view, `$view`, as below. 

```php
$view = $book->createView();
```

or, validate inputs then create a view. 

```php
$validation = $book->createValidation($_POST);
$view = $validation->createView();
```

### HTML Form

once a view is created, show html forms as such. 

```html
<form>
<?= $view['title']; ?>
<?= $view['abstract']; ?>
</form>
```