<?php
class RatingCrud {
    private Crud $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function getRatingByProductId($productId) {
        $sql = "SELECT AVG(R.rating) AS rating
                FROM ratings AS R
                INNER JOIN products AS P ON P.product_id = R.product_id
                WHERE R.product_id = :productId";
        $values = array("productId" => $productId);

        return $this->crud->readOneRow($sql, $values);
    }

    public function getRatingForAllProducts() {
        $sql = "SELECT DISTINCT R.product_id AS productId, AVG(R.rating) AS rating
                FROM ratings AS R
                GROUP BY R.product_id";

        return $this->crud->readMultipleRows($sql);
    }

    public function getRatingForAllProductsByUserId($userId){
        $sql = "SELECT DISTINCT R.product_id AS productId, R.rating AS rating
                FROM ratings AS R
                LEFT JOIN ratings AS R2 ON R.user_id = :userId
                GROUP BY R.product_id";
        $values = array("userId" => $userId);

        return $this->crud->readMultipleRows($sql, $values);
    }

    public function updateRatingByProductIdForUserId($userId, $productId, $rating) {
        $sql = "UPDATE ratings 
                SET rating = :rating
                WHERE product_id = :productId AND user_id = :userId";
        $values = array("userId" => $userId, "productId" => $productId, "rating" => $rating);

        $this->crud->updateRow($sql, $values);
    }

    public function writeRatingByproductIdForUserId($userId, $productId, $rating) {
        $sql = "INSERT INTO ratings (product_id, user_id, rating)
                VALUES (:productId, :userId, :rating)";
        $values = array("userId" => $userId, "productId" => $productId, "rating" => $rating);

        $this->crud->createRow($sql, $values);
    }

    public function doesProductExist($productId) {
        return !empty($this->readProduct($productId));
    }

    public function getRatingByProductIdForUserId($userId, $productId) {
        $sql = "SELECT P.product_id AS product, COALESCE(A.rating, B.rating) AS rating
            FROM products AS P
            LEFT JOIN (
                SELECT product_id, rating
                FROM ratings
                WHERE user_id = :userId
                GROUP BY product_id
                ) AS A ON P.product_id = A.product_id         
            LEFT JOIN (
                SELECT product_id, AVG(rating) AS rating
                FROM ratings
                WHERE user_id != :userId
                GROUP BY product_id
                ) AS B ON P.product_id = B.product_id
            WHERE P.product_id = :productId
            ORDER BY P.product_id";
        $values = array("userId" => $userId, "productId" => $productId);

        return $this->crud->readOneRow($sql, $values);
    }

    public function readProduct($productId) {
        $sql = "SELECT * FROM products WHERE product_id = :productId";
        $productId = array("productId" => $productId);

        return $this->crud->readOneRow($sql, $productId);
    }
}
?>