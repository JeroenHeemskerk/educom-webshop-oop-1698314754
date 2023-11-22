<?php
class AjaxModel extends PageModel {
    public $action;
    public $productId;
    public $JSON;

    private RatingCrud $ratingCrud;

    public function doGetAverageRatingByProductId() {
        $this->productId = Util::getUrlVar("productId");
        $this->ratingCrud->getRatingByProductId($this->productId);
    }

    public  function doGetAverageRatingForAllProducts() {
        $this->ratingCrud->getRatingForAllProducts();
    }

    public  function doUpdateRatingByProductIdForUserId() {

    }

    public  function doWriteRatingByProductIdForUserId() {

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