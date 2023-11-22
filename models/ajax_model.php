<?php
class AjaxModel extends Validate {
    private $productId;
    private $rating;

    public $action;
    public $errRating;
    public $json;

    private RatingCrud $ratingCrud;

    public function doGetAverageRatingByProductId() {
        $this->productId = Util::getUrlVar("productId");
        $data = $this->ratingCrud->getRatingByProductId($this->productId);
        $this->json = json_encode($data);
    }

    public  function doGetAverageRatingForAllProducts() {
        $data = $this->ratingCrud->getRatingForAllProducts();
        $this->json = json_encode($data);
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

    public function validateProductId() {
        if ($this->isPost){
            $this->productId = $this->testInput(Util::getPostVar("productId"));
        } else {
            $this->productId = $this->testInput(Util::getUrlVar("productId"));
        }

        $this->errProductId = $this->checkProductId($this->productId);

        //Door deze functie RatingCrud ShopCrud laten extenden
        if ($this->errProductId == "") {
            try {
                if ($this->ratingCrud->doesProductExist($this->productId)) {
                    $this->valid = True;
                }
            } catch(Exception $e) {
                $this->genericError = "Er is iets fout gegaan. Een niet bestaand product is opgevraagd. Probeer het later opnieuw.";
                logError($e->getMessage()); //Schrijf $e naar log functie
            }
        }
    }

    public function validateProductIdAndRating() {
        if ($this->isPost){
            $this->productId = $this->testInput(Util::getPostVar("productId"));
        } else {
            $this->productId = $this->testInput(Util::getUrlVar("productId"));
        }

        $this->errProductId = $this->checkProductId($this->productId);
        $this->errRating = $this->checkRating($this->rating);

        //Door deze functie RatingCrud ShopCrud laten extenden
        if ($this->errProductId == "" && $this->errRating) {
            try {
                if ($this->ratingCrud->doesProductExist($this->productId)) {
                    $this->valid = True;
                }
            } catch(Exception $e) {
                $this->genericError = "Er is iets fout gegaan. Een niet bestaand product is opgevraagd. Probeer het later opnieuw.";
                logError($e->getMessage()); //Schrijf $e naar log functie
            }
        }
    }
}
?>