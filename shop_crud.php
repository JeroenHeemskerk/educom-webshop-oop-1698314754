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
        $sql = "SELECT * FROM products";

        return $this->crud->readMultipleRows($sql);
    }

    public function readProduct($productId) {
        $sql = "SELECT * FROM products WHERE product_id = :productId";
        $productId = array("productId" => $productId);

        return $this->crud->readOneRow($sql, $productId);
    }

    public function readOrdersAndSum() {
        
    }

    public function readRowsByOrderId($orderId) {

    }
}