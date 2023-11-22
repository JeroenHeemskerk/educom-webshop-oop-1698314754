<?php
class AjaxModel extends PageModel {
    public $action;

    private $json;
    private $productId;
    private $rating;

    private RatingCrud $ratingCrud;

    public function doGetAverageRatingByProductId() {
        $this->productId = Util::getUrlVar("productId");
        $data = $this->ratingCrud->getRatingByProductId($this->productId);
        $this->json = json_encode($data);
        //Vervolgens teruggeven (echo?)
    }

    public  function doGetAverageRatingForAllProducts() {
        $data = $this->ratingCrud->getRatingForAllProducts();
        $this->json = json_encode($data);
        //Vervolgens teruggeven (echo?)
    }

    public function doUpdateRatingByProductIdForUserId() {
        $userId = $this->sessionManager->getLoggedInUserId();
        $this->productId = Util::getPostVar("productId");
        $this->rating = Util::getPostVar("rating");
        $this->ratingCrud->updateRatingByProductIdForUserId($userId, $this->productId, $this->rating);
    }

    public function doWriteRatingByProductIdForUserId() {
        $userId = $this->sessionManager->getLoggedInUserId();
        $this->productId = Util::getPostVar("productId");
        $this->rating = Util::getPostVar("rating");
        $this->ratingCrud->writeRatingByproductIdForUserId($userId, $this->productId, $this->rating);
    }

    public function setAction() {
        if ($this->isPost){
            $this->action = Util::getPostVar("action");
        } else {
            $this->action = Util::getUrlVar("action");
        }
    }
}
?>