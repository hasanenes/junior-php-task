<?php

class ProductsHandler
{
    protected $productHandlers;

    public function __construct($productHandlers)
    {
        $this->productHandlers = $productHandlers;
    }


    public function renderAllProducts()
    {
        $result = [];
        foreach ($this->productHandlers as $productHandler) {
            array_push($result, ...$productHandler->getAllObjects());

        }
        foreach ($result as $product) {
            $product->render();
        }
    }

    public function massDeleteProducts($assocArray)
    {

        if (isset($assocArray['products'])) {
            foreach ($assocArray['products'] as $sku) {
                foreach ($this->productHandlers as $productHandler) {
                    $productHandler->deleteBySKU($sku);
                }
            }
        }
    }

    public function getAllProductNames(): array
    {
        $productNames = [];
        foreach ($this->productHandlers as $productHandler) {
            $productNames[] = $productHandler->getTypeName();
        }
        return $productNames;
    }
}
