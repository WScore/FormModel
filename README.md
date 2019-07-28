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

### Create a FormModel 

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
use WScore\FormModel\Type\TextAreaType;
use WScore\FormModel\Type\TextType;

$book
    ->add('title', TextType::class, [
        'label' => 'Book Title',
    ])
    ->add('abstract', TextAreaType::class, [
        'label' => 'Abstracts',
        'attributes' => [
            'style' => 'height: 5em;',
        ]
    ]);
```

usage: `add($name, $typeName, $options);`,

- `$name`: name of the element, 
- `$typeName`: class name of the element type,
- `$options`: an array of options. 

### Validate Input

to validate input values, such as form,

```php
$validation = $book->createValidation($_POST);
if ($validation->isValid()) {
    $data = $validation->getData();
} else {
    $data = []; // just in case...
}
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

once a view is created, show html forms as such. 

```html
<form>
<?= $view['title']; ?>
<?= $view['abstract']; ?>
</form>
```