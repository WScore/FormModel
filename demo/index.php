<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/builder.php';

$book = buildForm();
$html = $book->createHtml();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">

    <h1>FormModel samples</h1>

    <form action="">

        <?= $html['title']->toString()->row(); ?>
        <div class="row">
            <div class="col-sm">
                <?= $html['published_at']->toString()->row(); ?>
            </div>
            <div class="col-sm">
                <?= $html['language']->toString()->row(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <?= $html['format']->toString()->row(); ?>
            </div>
            <div class="col-sm">
                <?= $html['type']->toString()->row(); ?>
            </div>
        </div>

        <h2>Publisher Information</h2>

        <h2>Authors Information</h2>

        <input type="submit" value="validate input!" class="btn btn-primary">
    </form>

</div>
</body>
</html>

