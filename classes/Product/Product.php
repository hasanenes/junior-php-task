<?php

namespace Product;

abstract class Product
{
    public $sku;
    public $name;
    public $price;


    abstract public function render();
}
