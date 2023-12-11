<?php
require_once "./session_manager.php";

class AjaxModel extends Validate {
    private $productId;
    private $rating;

    public $action;
    public $data;
    public $errRating;
    public $valid;

    private RatingCrud $ratingCrud;

    public function __construct($pageModel, $ratingCrud) {
        parent::__construct($pageModel);
        $this->ratingCrud = $ratingCrud;

        if ($this->sessionManager->isUserLoggedIn()) {
            $this->userId = $this->sessionManager->getLoggedInUserId();
        }
    }

    public function doGetAverageRatingByProductId() {
        $this->productId = Util::getUrlVar("productId");
        try {
            if ($this->userId == "") {
                $this->data = $this->ratingCrud->getRatingByProductId($this->productId);
            } else {
                $this->data = $this->ratingCrud->getRatingByUserIdOrAverageRating($this->userId, $this->productId);
            }
        }
        catch(Exception $e) {
            $this->genericError = "Rating voor dit product is op dit moment niet beschikbaar.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }
    }

    public function doGetAverageRatingForAllProducts() {
        try {
            if ($this->userId == "") {
                $this->data = $this->ratingCrud->getRatingForAllProducts();
            } else {
                $this->data = $this->ratingCrud->getRatingForAllProductsByUserIdOrAverageRating($this->userId);
            }
        }
        catch(Exception $e) {
            $this->genericError = "Ratings voor producten in de webshop zijn op dit moment niet beschikbaar.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }
    }

    public function doUpdateRatingByProductIdForUserId() {
        $this->rating = Util::getPostVar("rating");
        try {
            $this->ratingCrud->updateRatingByProductIdForUserId($this->userId, $this->productId, $this->rating);
        }
        catch(Exception $e) {
            $this->genericError = "Rating kan op dit moment niet geupdate worden.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }
    }

    public function doWriteRatingByProductIdForUserId() {
        $this->rating = Util::getPostVar("rating");
        try {
            $this->ratingCrud->writeRatingByproductIdForUserId($this->userId, $this->productId, $this->rating);
        }
        catch(Exception $e) {
            $this->genericError = "Rating kan op dit moment niet opgegeven worden.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }
    }

    public function isRatingForProductByUserSet() {
        try {
            $result = $this->ratingCrud->getRatingByProductIdForUserId($this->productId, $this->userId);
        }
        catch(Exception $e) {
            $this->genericError = "Rating kan op dit moment niet opgehaald worden.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }
        if (!empty($result)) {
            return True;
        } else {
            return False;
        }
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
            $this->rating = $this->testInput(Util::getPostVar("rating"));
        } else {
            $this->productId = $this->testInput(Util::getUrlVar("productId"));
            $this->rating = $this->testInput(Util::getUrlVar("rating"));
        }

        $this->errProductId = $this->checkProductId($this->productId);
        $this->errRating = $this->checkRating($this->rating);

        if ($this->errProductId == "" && $this->errRating == "") {
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