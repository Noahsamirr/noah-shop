<?php
require_once '../objects/Book.php';
require_once '../objects/Dvd.php';
require_once '../objects/Furniture.php';
require_once '../objects/Product.php';

class Database
{

    private const TABLE_NAME = 'products';
    
    // live database credentials
    private $host = "ec2-34-235-31-124.compute-1.amazonaws.com";
    private $db_name = "dc71mss5fmt7st";
    private $username = "jqwpldyrptiwyw";
    private $password = "beb0aecabe4fddbb6a45aa4b9b1f88310a125530db56b11518626e3586b64882";
    public $conn;

    public function __construct()
    {
        $this->conn = $this->getConnection();
    }
    // get the database connection
    private function getConnection()
    {

        $conn = null;

        try {
            $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $conn;
    }

    // read products
    function read()
    {
        // select all query
        $query = "SELECT * FROM " . self::TABLE_NAME . " ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create product
    function createProduct(Product $product)
    {
        // query to insert record
        $query = "INSERT INTO " . self::TABLE_NAME .
            " SET name=:name, 
            type=:type, 
            sku=:sku,
            price=:price, 
            size=:size,
            height=:height, 
            width=:width,
            length=:length, 
            weight=:weight";

        // prepare query
        $stmt = $this->conn->prepare($query);
        $name = $product->getName();
        $sku = $product->getSku();
        $price = $product->getPrice();
        $type = $product->getType();

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":sku", $sku);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":type", $type);


        $product->bindProductSqlStmtParams($stmt);


        // execute query
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $e) {
            echo 'error', $e->getMessage();
        }


        return false;
    }


    // delete the product
    function deleteProduct(string $productSku)
    {

        // delete query
        $query = "DELETE FROM " . self::TABLE_NAME . " WHERE sku = :sku";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind id of record to delete
        $stmt->bindParam('sku', $productSku);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
