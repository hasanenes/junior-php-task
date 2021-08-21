<?php
$databaseHandler = new DatabaseHandler();
$productHandlers = [
    ProductHandlerFactory::makeProductHandler('Book', $databaseHandler),
    ProductHandlerFactory::makeProductHandler('Furniture', $databaseHandler),
    ProductHandlerFactory::makeProductHandler('DVD', $databaseHandler),
];
$productsHandler = new ProductsHandler($productHandlers);
