FormModel
=========

a framework agnostic component for HTML form and validation models. 

Trying to replicate something similar to Symfony's Form component... 
but is very hard to do, as expected. 

How To
------

### Set Up FormModel 

```php
$builder = new FormBuilder('user');
$builder->addText('name')->required();
$builder->addRadioButtons('use')
    ->addLabel('Using it is...')
    ->addOption('difficult', 'DIFF')
    ->addOption('simple', 'SIMP')
    ->addOption('easy', 'EASE');
$model = $builder->build();
```

### Show HTML Form

```php
<?php $form = $model->getForm('name') ?>
<label><?= $form->label() ?></label>
<?= $form->toHtmlForm(); ?>

<?php $form = $model->getForm('use') ?>
<label><?= $form->lLabel() ?></label>
<ul>
<?php foreach($form->getOptions() as $option): ?>
    <li><label><?= $option->toHtmlForm(); ?>:<?= $form->label(); ?></label></li>
<?php endforeach; ?>
</ul>
```

### Validate Input

```php
$model->validate($_POST);
if ($model->isValid()) {
    // do something
}
```