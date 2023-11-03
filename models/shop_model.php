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

    function getCartLines() {    
        $this->genericError = "";
        $this->cart = $this->sessionManager->getShoppingCart();
        $this->cartTotal = 0;
        try {
            $this->products = getAllProducts(); // getSpecificProducts(array_keys($cart))
            foreach ($this->cart as $productId => $amount) {
                if (!array_key_exists($productId, $this->products)){
                    continue;
                }
                $this->product = $this->products[$productId];
                $subTotal = $this->product['price'] * $amount;
                $this->cartTotal += $subTotal;
                $this->cartLines[$productId] = array('name' => $this->product['name'], 'description' => $this->product['description'], 'price' => $this->product['price'], 'product_picture_location' => $this->product['product_picture_location'], 'amount' => $amount, 'subTotal' => $subTotal);
            }
        }
        catch(Exception $e) {
            $this->genericError = "Helaas kunnen wij de producten op dit moment niet laten zien. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }        
    }

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
                $this->validateAddingProductToShoppingCart();
                if ($this->valid){
                    $this->sessionManager->addProductToShoppingCart($this->productId, $this->quantity);
                }
            case "completeOrder":
                $this->writeOrder($this->cartLines);
                if ($this->valid) {
                    $this->sessionManager->emptyShoppingCart();
                    unset($this->cartLines);
                }
        }
    }

    public function validateAddingProductToShoppingCart() {

        if ($this->isPost){

            //Eerst worden ongewenste karakters verwijderd
            $this->productId = $this->testInput(getPostVar("productId"));
            $this->quantity = $this->testInput(getPostVar("quantity"));

            //Vervolgens wordt gekeken of correcte input gegeven is
            $this->errProductId = $this->checkProductId($this->productId);
            $this->errQuantity = $this->checkQuantity($this->quantity);
            
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
    
    function writeOrder() {
        $this->genericError = "";
        $this->valid = False;
        try {
            writeOrderToDatabase($this->cartLines);
        } catch (Exception $e) {
            $this->genericError = "Door een technisch probleem is het op dit moment helaas niet mogelijk om iets aan te schaffen. Probeer het op een later moment nogmaals.<br>";
            logError($e->getMessage()); //Schrijf $e naar log functie (deze doet niks op dit moment want is conform opdracht niet geïmplementeerd)
        }

        if (empty($genericError)) {
            $this->valid = True;
        }
    }
}

?>