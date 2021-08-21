<?php

namespace Product;

class Furniture extends Product
{
    public string $height;
    public string $width;
    public string $length;

    public function __construct($sku, $name, $price, $height, $width, $length)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function render()
    {
        $dimension = $this->height . 'x' . $this->width . 'x' . $this->length;
        echo "
                  <div class ='product'>
                    <input type='checkbox' name='products[]' class='delete-checkbox' value='$this->sku'>
                    <p>$this->sku</p>
                    <p>$this->name</p>
                    <p>$this->price $</p>
                    <p>$dimension</p>
                  </div>
                    ";
    }
}
