<?php

class SessionManager {
    
    public function getLoggedInUsername() {
        return $_SESSION['user'];
    }
    
    public function isUserLoggedIn() {
        return isset($_SESSION['user']);
    }
    
    public function loginUser($name, $email) {        
        $_SESSION['user'] = $name;
        //Email wordt ook geset zodat dit gebruik kan worden om een order weg te schrijven in de database
        $_SESSION['email'] = $email;
    }
    
    public function logoutUser() {        
        unset($_SESSION['user']);
        unset($_SESSION['cart']);
    }
    
    public function createShoppingCart() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    public function emptyShoppingCart() {
        unset($_SESSION['cart']);
    }

    public function addProductToShoppingCart($productId, $quantity) {

        //Product wordt eerst geset indien deze nog niet aangemaakt was in de array
        if (!isset($_SESSION['cart'][$productId])){
            $_SESSION['cart'][$productId] = 0;
        } 
            
        $_SESSION['cart'][$productId] += $quantity;
    }

    public function getShoppingCart() {
        if (isset($_SESSION['cart'])) {
            return $_SESSION['cart'];
        } else {
            $this->createShoppingCart();
            return $_SESSION['cart'];
        }
    }
}
?>