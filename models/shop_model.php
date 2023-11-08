<?php
require_once "./util.php";
require_once "./session_manager.php";

class ShopModel extends Validate {
    public $product, $total, $action, $productId, $quantity, $orderId;
    public $errProductId = "", $errQuantity = ""; 
    public $cartLines = array();
    public $order = array();
    public $orders = array();
    public $products = array();
    public $rows = array();

    private ShopCrud $shopCrud;

    public function __construct($pageModel, $shopCrud) {
        parent::__construct($pageModel);
        $this->shopCrud = $shopCrud;
    }

    public function getCartLines() {    
        $cart = $this->sessionManager->getShoppingCart();
        $this->total = 0;
        try {
            $this->products = $this->shopCrud->readAllProducts(); //getSpecificProducts(array_keys($cart))
            foreach ($this->products as $key => $value) {
                //Dit kan efficienter met een getSpecificProducts

                //Als productId niet gematcht wordt met een product wordt dit productId overgeslagen
                if (!array_key_exists($value->product_id, $cart)){
                    continue;
                }                
                $this->product = $this->products[$key];
                $amount = $cart[$value->product_id];
                $subTotal = $this->product->price * $amount;
                $this->total += $subTotal;
                $this->cartLines[$key] = array('productId' => $this->product->product_id, 'name' => $this->product->name,
                'description' => $this->product->description, 'price' => $this->product->price,
                'productPictureLocation' => $this->product->product_picture_location, 'amount' => $amount,
                'subTotal' => $subTotal);
            }
        }
        catch(Exception $e) {
            $this->genericError = "Helaas kunnen wij de producten op dit moment niet laten zien. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }        
    }

    public function getOrderAndSum() {

        try {
            $this->order = $this->shopCrud->readOrderAndSum($this->orderId);
        }
        catch(Exception $e) {
            $this->genericError = "Helaas zijn uw orders op dit moment niet beschikbaar. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }
    }

    public function getOrdersAndSum() {
        try {
            $this->orders = $this->shopCrud->readOrdersAndSum();
        }
        catch(Exception $e) {
            $this->genericError = "Helaas zijn uw orders op dit moment niet beschikbaar. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }
    }

    public function getRowsByOrderId() {

        $this->orderId = $this->testInput(Util::getUrlVar('orderId'));

        try {
            $this->rows = $this->shopCrud->readRowsByOrderId($this->orderId);
        }
        catch(Exception $e) {
            $this->genericError = "Helaas zijn uw orders op dit moment niet beschikbaar. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }
    }

    public function getWebshopProductDetails() {

        if ($this->isPost) {
            $this->productId = Util::getPostVar('productId');
        } else {
            $this->productId = Util::getUrlVar('productId');
        }

        $this->sessionManager->createShoppingCart(); 

        try {
            $this->product = $this->shopCrud->readProduct($this->productId);
        }
        catch(Exception $e) {
            $this->genericError = "Helaas kunnen wij dit product op dit moment niet laten zien. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }
    }

    public function getWebshopProducts() {    
        $this->sessionManager->createShoppingCart();

        try {
            $this->products = $this->shopCrud->readAllProducts();
        }
        catch(Exception $e) {
            $this->genericError = "Helaas kunnen wij de producten op dit moment niet laten zien. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }    
    }

    public function handleActions() {
        //handleActions zorgt voor de afhandeling van bijvoorbeeld het toevoegen van een product aan de cart
        $this->action = Util::getPostVar('userAction');

        switch ($this->action) {
            case "addToCart":
                $this->validateAddingProductToShoppingCart();
                if ($this->valid){
                    $this->sessionManager->addProductToShoppingCart($this->productId, $this->quantity);
                }
                break;
            case "completeOrder":
                $this->createOrder($this->cartLines);
                if ($this->valid) {
                    $this->sessionManager->emptyShoppingCart();
                    unset($this->cartLines);
                }
                break;
        }
    }

    public function validateAddingProductToShoppingCart() {

        if ($this->isPost){

            //Eerst worden ongewenste karakters verwijderd
            $this->productId = $this->testInput(Util::getPostVar("productId"));
            $this->quantity = $this->testInput(Util::getPostVar("quantity"));

            //Vervolgens wordt gekeken of correcte input gegeven is
            $this->errProductId = $this->checkProductId($this->productId);
            $this->errQuantity = $this->checkQuantity($this->quantity);
            
            //Indien sprake is van correcte input wordt het product aan de cart toegevoegd
            if ($this->errProductId == "" && $this->errQuantity == "") {

                try {
                    if ($this->shopCrud->doesProductExist($this->productId)) {
                        $this->valid = True;
                    }
                } catch(Exception $e) {
                    $this->genericError = "Er is iets fout gegaan. Een niet bestaand product is opgevraagd. Probeer het later opnieuw.";
                    logError($e->getMessage()); //Schrijf $e naar log functie
                }
            }
        }
    }
    
    public function createOrder() {
        $this->valid = False;

        try {
            $this->shopCrud->writeOrder($this->cartLines);
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