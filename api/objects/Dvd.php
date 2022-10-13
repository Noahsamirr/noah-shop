<?php
include_once 'Product.php';

class Dvd extends Product implements Type
{
    public $size;

    public function __construct($name, $sku, $price, $size)
    {
        parent::__construct($name, $sku, $price);
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getSpecialData(): string
    {
        return "Size: {$this->size} MB";
    }

    public function getType()
    {
        return 'dvd';
    }

    //get the passed data
    public static function fromArray(array $row)
    {
        return new self(
            $row["name"] ?? null,
            $row["sku"] ?? null,
            $row["price"] ?? null,
            $row["size"] ?? null
        );
    }

    //create an object of the passed data
    public function toArray()
    {
        $data = [
            'name' => $this->getName(),
            'sku' => $this->getSku(),
            'price' => $this->getPrice(),
            'size' => $this->getSize(),
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
        $stmt->bindParam(":size", $this->size);
        $stmt->bindParam(":weight", $nullValue);
        $stmt->bindParam(":height", $nullValue);
        $stmt->bindParam(":width", $nullValue);
        $stmt->bindParam(":length", $nullValue);
    }
}
