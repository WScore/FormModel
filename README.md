FormModel
=========

a framework agnostic component for HTML form and validation models. 

Trying to replicate something similar to Symfony's Form component... 
but is very hard to do, as expected. 

How To
------

### Set Up FormModel 

```php
$fb = new FormBuilder();
$form = $fb->form('user');
$form->add($fb->text('name')->required());
$form->add($fb->email('email')->required());
```

### Show HTML Form

```php
<?php
$html = $form->createHtml();
?>
<html>
<?= $form['name']; ?>

<div class="form-label"><?= $form['name']->label() ?></div>
<div class="form-value"><?= $form['name']->widget(); ?></div>
</html>
```

### Validate Input

```php
$validator = $form->createValidation();
$results = $validator->validate($_POST);
if ($results->isValid()) {
    // do something
} else {
    foreach($results as $result) {
        if (!$result->isValid()) {
            $result->getErrorMessage();
        }
    }
}
```