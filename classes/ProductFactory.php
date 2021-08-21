<?php


// properties contain POST
use Product\Book;
use Product\DVD;
use Product\Furniture;

class ProductFactory
{
    public static function makeProduct($productType, $properties): DVD|Furniture|Book
    {
        $product = null;
        if ($productType === 'Book') {
            $product = new Product\Book(
                $properties['sku'],
                $properties['name'],
                $properties['price'],
                $properties['weight']
            );
        }

        if ($productType === 'DVD') {
            $product = new Product\DVD(
                $properties['sku'],
                $properties['name'],
                $properties['price'],
                $properties['size']
            );
        }

        if ($productType === 'Furniture') {
            $product = new Product\Furniture(
                $properties['sku'],
                $properties['name'],
                $properties['price'],
                $properties['height'],
                $properties['width'],
                $properties['length']
            );
        }

        if ($product == null) {
            throw new Error("Unrecognized Product Type: $productType");
        }

        return $product;
    }
}
