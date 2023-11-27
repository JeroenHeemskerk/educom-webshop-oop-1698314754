<?php
class ShopCrud {
    private Crud $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function writeOrder($cartLines) {
        $sql = "INSERT INTO orders (user_id)
        VALUES (:userId)";
        $userId = array("userId" => $_SESSION['userId']);

        $orderId = $this->crud->createRow($sql, $userId);
        
        $sql = "INSERT INTO order_row (order_id, product_id, amount)
        VALUES (:orderId, :productId, :amount)";        
        foreach ($cartLines as $key => $value) {
            $values[$key] = array("orderId" => $orderId , "productId" => $value['productId'], "amount" => $value['amount']);
        }

        $this->crud->createRow($sql, $values, True);        
    }

    public function doesProductExist($productId) {
        return !empty($this->readProduct($productId));
    }

    public function readAllProducts() {
        $sql = "SELECT product_id AS productId, name, description, price,
            product_picture_location AS productPictureLocation
            FROM products";

        return $this->crud->readMultipleRows($sql);
    }

    public function readSpecificProducts($cartIds) {
        $sql = "SELECT product_id AS productId, name, description, price,
            product_picture_location AS productPictureLocation
            FROM products 
            WHERE product_id = :productId";
        foreach($cartIds as $key => $value) {
            $productIds[$key] = array("productId" => $value);
        }

        return $this->crud->readMultipleRows($sql, $productIds, True);
    }

    public function readProduct($productId) {
        $sql = "SELECT product_id AS productId, name, description, price,
            product_picture_location AS productPictureLocation
            FROM products
            WHERE product_id = :productId";
        $productId = array("productId" => $productId);

        return $this->crud->readOneRow($sql, $productId);
    }

    public function readOrdersAndSum() {
        $sql = "SELECT order_row.order_id AS orderId, SUM(order_row.amount * products.price) AS total
            FROM order_row
            INNER JOIN products
                ON order_row.product_id = products.product_id
            INNER JOIN orders 
                ON order_row.order_id = orders.order_id
            WHERE orders.user_id = :userId
            GROUP BY order_row.order_id";
        $values = array("userId" => $_SESSION['userId']);

        return $this->crud->readMultipleRows($sql, $values);
    }

    public function readOrderAndSum($orderId) {
        $sql = "SELECT order_row.order_id, SUM(order_row.amount * products.price) AS total
        FROM order_row
        INNER JOIN products
            ON order_row.product_id = products.product_id
        INNER JOIN orders 
            ON order_row.order_id = orders.order_id
        WHERE orders.user_id = :userId AND order_row.order_id = :orderId
        GROUP BY order_row.order_id";
        $values = array("userId" => $_SESSION['userId'], "orderId" => $orderId);

        return $this->crud->readOneRow($sql, $values);
    }

    public function readRowsByOrderId($orderId) {
        $sql = "SELECT order_row.order_id, order_row.row_id, order_row.product_id AS productId,
            order_row.amount, products.name, products.price, products.product_picture_location
            AS productPictureLocation, price * amount AS total
            FROM order_row
            INNER JOIN products
                ON order_row.product_id = products.product_id
            INNER JOIN orders 
                ON order_row.order_id = orders.order_id
            WHERE (orders.user_id = :userId AND order_row.order_id = :orderId)
            ORDER BY row_id";
        $values = array("userId" => $_SESSION['userId'], "orderId" => $orderId);

        return $this->crud->readMultipleRows($sql, $values);
    }
}