<?php

namespace Handler;

class ProductHandler
{
    public function __construct($db)
    {
        $this->db = $db;
        $createProductTable = "CREATE TABLE if not exists products(
                    id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
                    sku varchar(256) NOT NULL UNIQUE,
                    name varchar(256) NOT NULL,
                    price decimal NOT NULL,
                    weight decimal NOT NULL,
                    size decimal NOT NULL,
                    height decimal NOT NULL,
                    width decimal NOT NULL,
                    length decimal NOT NULL 
                     )";

        $this->db->conn->query($createProductTable);
    }

    public function addProduct($product)
    {

        $insertValues = [$product->sku, $product->price, $product->name, $product->weight,$product->size,$product->height,$product->width,$product->length,];
        $cleanedInsertValues = array();

        foreach ($insertValues as $insertValue) {
            $cleanedInsertValues[] = $this->cleanData($insertValue);
        }

        $insertQuery = "INSERT INTO products( sku, price, name, weight, size, height, width, length) VALUES(?,?,?,?,?,?,?,?)";
        $queryToExecute = $this->db->conn->prepare($insertQuery);
        $queryToExecute->execute($cleanedInsertValues);


    }


    public function getAllObjects()
    {
        $rawResult = $this->db->conn->query('SELECT * FROM `products`');
        return $rawResult->fetchAll(PDO::FETCH_CLASS| PDO::FETCH_CLASSTYPE | PDO::FETCH_PROPS_LATE, "Product", [0, 0, 0, 0]);
    }

    public function getTypeName(): string
    {
        return 'Book';
    }

    public function deleteBySku($sku)
    {
        $preparedStatement = $this->db->conn->prepare('DELETE FROM `products` where sku=?');
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


            if (self::isSkuDuplicate($product)) {
                $errorArray['skuErr'] = "Duplicate SKU exists: $product->sku";
            }
        }

        if (empty($product->weight)) {
            $errorArray["weightErr"] = "Please enter a weight";
        } elseif (!is_numeric($product->weight)) {
            $errorArray["weightErr"] = $plsProvideDataOfIndicatedType;
        }

        if (empty($product->size)) {
            $errorArray["sizeErr"] = "Please enter a size";
        } elseif (!is_numeric($product->size)) {
            $errorArray["sizeErr"] = $plsProvideDataOfIndicatedType;
        }

        if (empty($product->height)) {
            $errorArray["heightErr"] = "Please enter a height";
        } elseif (!is_numeric($product->height)) {
            $errorArray["heightErr"] = $plsProvideDataOfIndicatedType;
        }

        if (empty($product->width)) {
            $errorArray["widthErr"] = "Please enter a width";
        } elseif (!is_numeric($product->width)) {
            $errorArray["widthErr"] = $plsProvideDataOfIndicatedType;
        }

        if (empty($product->length)) {
            $errorArray["lengthErr"] = "Please enter a weight";
        } elseif (!is_numeric($product->length)) {
            $errorArray["lengthErr"] = $plsProvideDataOfIndicatedType;
        }

        return $errorArray;
    }

    public function cleanData($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    public function isSkuDuplicate($product)
    {

        $findSKUBook = $this->db->conn
            ->prepare('SELECT * FROM book where sku=?');
        $findSKUBook->execute([$product->sku]);

        $findSKUDVD = $this->db->conn
            ->prepare('SELECT * FROM dvd where sku=?');
        $findSKUDVD->execute([$product->sku]);

        $findSKUFurniture = $this->db->conn
            ->prepare('SELECT * FROM furniture where sku=?');
        $findSKUFurniture->execute([$product->sku]);
        return $findSKUBook->rowCount() > 0
            || $findSKUDVD->rowCount() > 0
            || $findSKUFurniture->rowCount() > 0;
    }
}
