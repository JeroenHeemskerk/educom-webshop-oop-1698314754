<?php
class ShopCrud {
    private Crud $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function createOrder() {
        $userId = getUserIdByEmail();

        $sql = "INSERT INTO orders (user_id)
        VALUES (:userId)";
        $userId = array("userId" => $userId);

        $this->crud->createRow($sql, $userId);
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