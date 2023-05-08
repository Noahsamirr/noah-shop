<?php
include_once 'Product.php';

class Book extends Product
{
    public $weight;

    public function __construct($name, $sku, $price, $weight)
    {
        parent::__construct($name, $sku, $price);
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getSpecialData(): string
    {
        return "Weight: {$this->weight} KG";
    }

    public function getType()
    {
        return 'book';
    }
    //get the passed data
    public static function fromArray(array $row)
    {
        return new self(
            $row["name"] ?? null,
            $row["sku"] ?? null,
            $row["price"] ?? null,
            $row["weight"] ?? null
        );
    }
    //insert the passed data into object
    public function toArray()
    {
        $data = [
            'name' => $this->getName(),
            'sku' => $this->getSku(),
            'price' => $this->getPrice(),
            'weight' => $this->getWeight(),
            'type' => $this->getType(),
            'specialData' => $this->getSpecialData()
        ];

        return array_filter($data, function ($x) {
            return $x !== null;
        });
    }

    public function bindProductSqlStmtParams($stmt)
    {
        $nullValue = null;
        $stmt->bindParam(":weight", $this->weight);
        $stmt->bindParam(":size", $nullValue);
        $stmt->bindParam(":height", $nullValue);
        $stmt->bindParam(":width", $nullValue);
        $stmt->bindParam(":length", $nullValue);
    }
}
