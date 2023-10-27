<?php

    function getWebshopProductDetails($productId) {
        
        $genericError = "";
        try {
            $product = getWebshopProduct($productId);
        }
        catch(Exception $e) {
            $genericError = "Helaas kunnen wij dit product op dit moment niet laten zien. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }

        return array('product' => $product, 'genericError' => $genericError);
    }

    function getWebshopProducts() {
    
        $genericError = ""; 
        try {
            $products = getAllProducts();
        }
        catch(Exception $e) {
            $genericError = "Helaas kunnen wij de producten op dit moment niet laten zien. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }    

        return array('products' => $products, 'genericError' => $genericError);
    }

    function getCartLines($cart) {
    
        $genericError = "";
        $cartLines = array();
        $total = 0;
        try {
            $products = getAllProducts(); // getSpecificProducts(array_keys($cart))
            foreach ($cart as $productId => $amount) {
                if (!array_key_exists($productId, $products)){
                    continue;
                }
                $product = $products[$productId];
                $subTotal = $product['price'] * $amount;
                $total += $subTotal;
                $cartLines[$productId] = array('name' => $product['name'], 'description' => $product['description'], 'price' => $product['price'], 'product_picture_location' => $product['product_picture_location'], 'amount' => $amount, 'subTotal' => $subTotal);
            }
        }
        catch(Exception $e) {
            $genericError = "Helaas kunnen wij de producten op dit moment niet laten zien. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }    

        return array('cartLines' => $cartLines, 'total' => $total, 'genericError' => $genericError);
        
    }

    function getRowsByOrderId($orderId) {
        $genericError = "";

        $orderId = testInput($orderId);

        try {
            $rows = getRowsByOrderIdFromDatabase($orderId);
        }
        catch(Exception $e) {
            $genericError = "Helaas zijn uw orders op dit moment niet beschikbaar. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }

        return array('rows' => $rows, 'orderId' => $orderId, 'genericError' => $genericError);
    }

    function getOrdersAndSum() {

        $genericError = "";

        try {
            $orders = getOrdersAndSumFromDatabase();
        }
        catch(Exception $e) {
            $genericError = "Helaas zijn uw orders op dit moment niet beschikbaar. Probeer het later opnieuw.";
            logError($e->getMessage()); //Schrijf $e naar log functie
        }

        return array('orders' => $orders, 'genericError' => $genericError);
    }

    function writeOrder($data) {

        $genericError = "";
        $valid = False;
        try {
            writeOrderToDatabase($data['cartLines']);
        } catch (Exception $e) {
            $genericError = "Door een technisch probleem is het op dit moment helaas niet mogelijk om iets aan te schaffen. Probeer het op een later moment nogmaals.<br>";
            logError($e->getMessage()); //Schrijf $e naar log functie (deze doet niks op dit moment want is conform opdracht niet geïmplementeerd)
        }

        if (empty($genericError)) {
            $valid = True;
        }
        return array('genericError' => $genericError, 'valid' => $valid);
    }

    function doesProductExist($productId) {
        return !empty(getWebshopProduct($productId));
    }
?>