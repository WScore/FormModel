<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/builder.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $book = buildForm();
    $html = $book->createHtml();
} else {
    $book = buildForm();
    // todo: use formElement's name when verify.
    $result = $book->createValidation()->verify($_POST['book']??[]);
    $html = $book->createHtml($_POST, $result);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="demo.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="header">
    <div class="container">
        <h1>Sample Form</h1>
        <p class="text-muted">This sample uses Bootstrap 4 and jQuery. </p>
    </div>
</div>

<div class="container">

    <?php if (isset($result)) : ?>
        <?php
            if ($result->isValid()) {
                echo '<div class="alert alert-success">Verified!</div>';
            } else {
                echo '<div class="alert alert-danger">Please check the input values!!!</div>';
            }
        ?>
    <?php endif; ?>

    <form id="sample-form" action="" method="post" novalidate="">

        <h2>Book Information</h2>
        <?= $html['title']->toString()->row(); ?>
        <div class="row">
            <div class="col-sm">
                <?= $html['published_at']->toString()->row(); ?>
            </div>
            <div class="col-sm">
                <?= $html['isbn_code']->toString()->row(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <?= $html['language']->toString()->row(); ?>
            </div>
            <div class="col-sm">
                <?= $html['format']->toString()->row(); ?>
            </div>
            <div class="col-sm">
                <?= $html['type']->toString()->row(); ?>
            </div>
        </div>

        <h2>Publisher Information</h2>
        <?php
        $publisher = $html['publisher'];
        ?>
        <?= $publisher['name']->toString()->row(); ?>
        <?= $publisher['url']->toString()->row(); ?>

        <h2>Authors Information</h2>

        <?php
        $authors = $html['authors'];
        ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th><label class="form-label required">Author's Name</label></th>
                    <th><label class="form-label required">Type</label></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($authors as $author): ?>
                    <tr>
                        <td><?= $author['name']->toString()->widget() ?>
                            <?= $author['name']->toString()->error() ?></td>
                        <td><?= $author['type']->toString()->widget() ?>
                            <?= $author['type']->toString()->error() ?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>

        <p class="text-info"><label><input type="checkbox" onclick="toggleValidation(this);"> turn on html validation.</label></p>
        <script>
            function toggleValidation(check) {
                let form = document.getElementById('sample-form');
                form.noValidate = !$(check).is(':checked');
            }
        </script>

        <input type="submit" value="validate input!" class="btn btn-primary">
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>

</div>
</body>
</html>

