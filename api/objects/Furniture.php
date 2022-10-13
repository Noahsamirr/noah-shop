<?php

include_once 'Product.php';

class Furniture extends Product
{
    public $height;
    public $width;
    public $length;

    public function __construct($name, $sku, $price, $height, $width, $length)
    {
        parent::__construct($name, $sku, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getSpecialData(): string
    {
        return "Dimensions: {$this->height}x{$this->width}x{$this->length} CM";
    }

    public function getType()
    {
        return 'furniture';
    }

    //get the passed data
    public static function fromArray(array $row)
    {
        return new self(
            $row["name"] ?? null,
            $row["sku"] ?? null,
            $row["price"] ?? null,
            $row["height"] ?? null,
            $row["width"] ?? null,
            $row["length"] ?? null
        );
    }

    //create an object of the passed data
    public function toArray()
    {
        $data = [
            'name' => $this->getName(),
            'sku' => $this->getSku(),
            'price' => $this->getPrice(),
            'height' => $this->getHeight(),
            'width' => $this->getWidth(),
            'length' => $this->getLength(),
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
        $stmt->bindParam(":height", $this->height);
        $stmt->bindParam(":width", $this->width);
        $stmt->bindParam(":length", $this->length);
        $stmt->bindParam(":size", $nullValue);
        $stmt->bindParam(":weight", $nullValue);
    }
}
