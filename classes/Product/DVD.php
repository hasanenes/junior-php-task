<?php

namespace Product;

class DVD extends Product
{
    public $size;

    public function __construct($sku, $name, $price, $size)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->size = $size;
    }

    public function render()
    {
        echo "
              <div class ='product'>
                <input type='checkbox' name='products[]' class='delete-checkbox' value='$this->sku'>
                <p>$this->sku</p>
                <p>$this->name</p>
                <p>$this->price $</p>
                <p>$this->size MB</p>
              </div>
              ";
    }
}
