<?php

//get headers
include_once  '../config/Headers.php';

// get database connection
include_once '../config/Database.php';


class GeneralController {
    public $database;
    public function __construct()
    {
        $this->database =new Database();
    }

    function getRequest() {
        $stmt = $this->database->read();
        $num = $stmt->rowCount();

        // check if more than 0 record found
        if ($num > 0) {

            // products array
            $products_arr = array();
            $products_arr["records"] = array();

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $product = null;
                $product = ucfirst($row["type"])::fromArray($row);
                array_push($products_arr["records"], $product->toArray());
            }

            // set response code - 200 OK
            http_response_code(200);

            // show products data in json format
            echo json_encode($products_arr);
        }
    }


    function postRequest() {
        // get posted data
        $data = json_decode(file_get_contents("php://input"));

        function dvdCreate($data)
        {
            return new Dvd(
                $data->name,
                $data->sku,
                $data->price,
                $data->size
            );
        }

        function furnitureCreate($data)
        {
            return new Furniture(
                $data->name,
                $data->sku,
                $data->price,
                $data->height,
                $data->width,
                $data->length
            );
        }

        function bookCreate($data)
        {
            return new Book(
                $data->name,
                $data->sku,
                $data->price,
                $data->weight
            );
        }
        // make sure common data is not empty
        if (
            !empty($data->name) &&
            !empty($data->type) &&
            !empty($data->sku) &&
            !empty($data->price)
        ) {
            $product = null;

            // set product property values
            $product = call_user_func("{$data->type}Create", $data);

            // create the product
            if ($this->database->createProduct($product)) {

                // set response code - 201 created
                http_response_code(201);

                // tell the user
                echo json_encode(array("message" => "Product was created."));
            }

            // if unable to create the product, tell the user
            else {

                // set response code - 503 service unavailable
                http_response_code(503);

                // tell the user
                echo json_encode(array("message" => "Unable to create product."));
            }
        } else {
            echo (print_r($_POST));
            // set response code - 400 bad request
            http_response_code(400);
        }

    }


    function deleteRequest() {
        //getting api call contents
        $data = json_decode(file_get_contents("php://input"), true);

        // set product id to be deleted
        try {
            foreach ($data["items"] as $sku) {
                $this->database->deleteProduct($sku);
            }
            http_response_code(200);
            echo json_encode(array("message" => "Products were deleted."));
        } catch (Exception $e) {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete products."));
        }
    }
}