<?php

use Handler\BookHandler;
use Handler\DVDHandler;
use Handler\FurnitureHandler;

class ProductHandlerFactory
{
    public static function makeProductHandler($productType, $db): FurnitureHandler|BookHandler|DVDHandler
    {
        $productHandler = null;
        if ($productType === 'Book') {
            $productHandler = new Handler\BookHandler($db);
        }

        if ($productType === 'DVD') {
            $productHandler = new Handler\DVDHandler($db);
        }


        if ($productType === 'Furniture') {
            $productHandler = new Handler\FurnitureHandler(
                $db
            );
        }

        if ($productHandler == null) {
            throw new Error("Unrecognized Product Type: $productType");
        }

        return $productHandler;
    }
}
