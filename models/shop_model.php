<?php

require_once "./util.php";
require_once "./session_manager.php";

class ShopModel extends Validate {
    public $product = "", $cartTotal = "", $action = "", $productId = "", $quantity = "";
    public $errProductId = "", $errQuantity = ""; 
    public $cart = array();
    public $cartLines = array();
    public $products = array();

    public $valid = False;

    function getWebshopProductDetails() {
        $this->genericError = "";
        $this->productId = getVar('productId');
        $this->sessionManager->createShoppingCart(); 
        try {
            $this->product = getWebshopProduct($this->productId);
        }
        catch(Exception $e) {
            $this->genericError = "Helaas kunnen wij dit product op dit moment niet laten zien. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }
    }

    public function getWebshopProducts() {    
        $this->genericError = "";
        $this->sessionManager->createShoppingCart();
        try {
            $this->products = getAllProducts();
        }
        catch(Exception $e) {
            $this->genericError = "Helaas kunnen wij de producten op dit moment niet laten zien. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }    
    }

    public function handleActions() {

        //handleActions zorgt voor de afhandeling van bijvoorbeeld het toevoegen van een product aan de cart
        $this->action = getVar('userAction');
        switch ($this->action) {
            case "addToCart":
                if ($this->valid){
                    $this->sessionManager->addProductToShoppingCart($this->productId, $this->quantity);
                }
            case "completeOrder":
                /*$data += writeOrder($data);
                if ($data['valid']) {
                    $this->sessionManager->emptyShoppingCart();
                    unset($data['cartLines']);
                }
                return $data;*/
        }
    }

    public function validateAddingProductToShoppingCart() {

        if ($this->isPost){

            //Eerst worden ongewenste karakters verwijderd
            $this->productId = testInput(getPostVar("productId"));
            $this->quantity = testInput(getPostVar("quantity"));

            //Vervolgens wordt gekeken of correcte input gegeven is
            $this->errProductId = checkProductId($this->productId);
            $this->errQuantity = checkQuantity($this->quantity);
            
            //Indien sprake is van correcte input wordt het product aan de cart toegevoegd
            if ($this->errProductId == "" && $this->errQuantity == "") {

                try {
                    if (doesProductExist($this->productId)) {
                        $this->valid = True;
                    }
                } catch(Exception $e) {
                    $this->genericError = "Er is iets fout gegaan. Een niet bestaand product is opgevraagd. Probeer het later opnieuw.";
                    logError($e->getMessage()); //Schrijf $e naar log functie
                }
            }
        }
    }    
}

?>