<?php

namespace Handler;

use PDO;

class FurnitureHandler extends ProductHandler
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
        $createFurnitureTable = "CREATE TABLE if not exists furniture(
                    id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
                    sku varchar(256) NOT NULL UNIQUE,
                    name varchar(256) NOT NULL,
                    price decimal NOT NULL,
                   
                     )";
        $this->db->conn->query($createFurnitureTable);
    }

    public function addProduct($product)
    {
        $insertValues = [
            $product->sku, $product->price, $product->name, $product->height, $product->width,
            $product->length];
        $cleanedInsertValues = array();

        foreach ($insertValues as $insertValue) {
            $cleanedInsertValues[] = $this->cleanData($insertValue);
        }

        $insertQuery = "INSERT INTO furniture( sku, price, name, height, width, length) VALUES(?,?,?,?,?,?)";
        $queryToExecute = $this->db->conn->prepare($insertQuery);
        $queryToExecute->execute($cleanedInsertValues);
    }


    public function getAllObjects()
    {
        $rawResult = $this->db->conn->query('SELECT * FROM `furniture`');
        return $rawResult->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Product\Furniture", [0, 0, 0, 0, 0, 0]);
    }

    public function getTypeName(): string
    {
        return 'Furniture';
    }

    public function deleteBySku($sku)
    {
        $preparedStatement = $this->db->conn->prepare('DELETE FROM `furniture` where sku=?');
        $preparedStatement->execute([$sku]);
    }

    public function validate($product): array
    {
        $plsProvideDataOfIndicatedType = 'Please, provide the data of indicated type';

        $errorArray = array();
        if (empty($product->name)) {
            $errorArray["nameErr"] = "Please enter a product name";
        }

        if (empty($product->price)) {
            $errorArray["priceErr"] = "Please enter a product price";
        } elseif (!is_numeric($product->price)) {
            $errorArray["priceErr"] = $plsProvideDataOfIndicatedType;
        }
        if (empty($product->sku)) {
            $errorArray["skuErr"] = "Please enter a sku";
        } else {

            if (parent::isSkuDuplicate($product)) {
                $errorArray['skuErr'] = "Duplicate SKU exists: $product->sku";
            }
        }

        if (empty($product->height)) {
            $errorArray["heightErr"] = "Please enter a height";
        } elseif (!is_numeric($product->height)) {
            $errorArray["heightErr"] = $plsProvideDataOfIndicatedType;
        }

        if (empty($product->length)) {
            $errorArray["lengthErr"] = "Please enter a length";
        } elseif (!is_numeric($product->length)) {
            $errorArray["lengthErr"] = $plsProvideDataOfIndicatedType;
        }

        if (empty($product->width)) {
            $errorArray["widthErr"] = "Please enter a width";
        } elseif (!is_numeric($product->width)) {
            $errorArray["widthErr"] = $plsProvideDataOfIndicatedType;
        }

        return $errorArray;
    }
}
