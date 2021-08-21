<?php

namespace Handler;

use PDO;

class DVDHandler extends ProductHandler
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
        $createDVDTable = "CREATE TABLE if not exists dvd(
                    id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
                    sku varchar(256) NOT NULL UNIQUE,
                    name varchar(256) NOT NULL,
                    price decimal NOT NULL,
                     )";

        $this->db->conn->query($createDVDTable);
    }

    public function addProduct($product)
    {
        $insertValues = [$product->sku, $product->price, $product->name, $product->size];
        $cleanedInsertValues = array();

        foreach ($insertValues as $insertValue) {
            $cleanedInsertValues[] = $this->cleanData($insertValue);
        }

        $insertQuery = "INSERT INTO dvd( sku, price, name, size) VALUES(?,?,?,?)";
        $queryToExecute = $this->db->conn->prepare($insertQuery);
        $queryToExecute->execute($cleanedInsertValues);
    }


    public function getAllObjects()
    {

        $rawResult = $this->db->conn->query('SELECT * FROM `dvd`');
        return $rawResult->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Product\DVD", [0, 0, 0, 0]);
    }

    public function getTypeName(): string
    {
        return 'DVD';
    }

    public function deleteBySku($sku)
    {
        $preparedStatement = $this->db->conn->prepare('DELETE FROM `dvd` where sku=?');
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

        if (empty($product->size)) {
            $errorArray["sizeErr"] = "Please enter a size";
        } elseif (!is_numeric($product->size)) {
            $errorArray["sizeErr"] = $plsProvideDataOfIndicatedType;
        }

        return $errorArray;
    }
}
