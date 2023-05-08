<?php

include_once 'Type.php';

abstract class Product implements Type
{
    // object properties
    private $id;
    private $name;
    private $sku;
    private $price;

    // constructor with properties
    public function __construct(
        $name,
        $sku,
        $price
    ) {
        $this->name = $name;
        $this->sku = $sku;
        $this->price = $price;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getSku()
    {
        return $this->sku;
    }
    public function getPrice()
    {
        return $this->price;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    abstract public function getType();

    abstract public function getSpecialData(): string;

    abstract static public function fromArray(array $row);

    abstract public function toArray();

    abstract public function bindProductSqlStmtParams($stmt);
}
