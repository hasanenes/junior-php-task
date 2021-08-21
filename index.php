<?php
/**
 * @var ProductsHandler $productsHandler
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/settings.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/autoload.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/products-handler.php';
$productsHandler->massDeleteProducts($_POST);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" type="text/css" href="./styles/index.css" media="screen"/>
</head>
<body>

<form action="" method="post">
    <header>
        <h1>Product List</h1>
        <Button type='button' onclick="window.location.href='add-product.php'">ADD</Button>
        <Button type="submit">MASS DELETE</Button>
    </header>

    <div id="ultra-main">
        <div id='main'>
            <?php
            $productsHandler->renderAllProducts();
            ?>
        </div>

</form>

</body>

</html>