<?php

namespace Product;

class Book extends Product
{
    public string $weight;

    public function __construct($sku, $name, $price, $weight)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->weight = $weight;
    }

    public function render()
    {
        echo "
                  <div class ='product'>
                    <input type='checkbox' name='products[]' class='delete-checkbox' value='$this->sku'>
                    <p>$this->sku</p>
                    <p>$this->name</p>
                    <p>$this->price $</p>
                    <p>$this->weight KG</p>
                  </div>
                    ";
    }
}
