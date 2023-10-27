<?php

    function getLoggedInUserName() {
        return $_SESSION['user'];
    }
    
    function isUserLoggedIn() {
        return isset($_SESSION['user']);
    }
    
    function loginUser($name, $email) {        
        $_SESSION['user'] = $name;
        //Email wordt ook geset zodat dit gebruik kan worden om een order weg te schrijven in de database
        $_SESSION['email'] = $email;
    }
    
    function logoutUser() {        
        unset($_SESSION['user']);
        unset($_SESSION['cart']);
    }
    
    function createShoppingCart() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    function emptyShoppingCart() {
        unset($_SESSION['cart']);
    }

    function addProductToShoppingCart($productId, $quantity) {

        //Product wordt eerst geset indien deze nog niet aangemaakt was in de array
        if (!isset($_SESSION['cart'][$productId])){
            $_SESSION['cart'][$productId] = 0;
        } 
            
        $_SESSION['cart'][$productId] += $quantity;
    }

    function getShoppingCart() {
        if (isset($_SESSION['cart'])) {
            return $_SESSION['cart'];
        } else {
            createShoppingCart();
            return $_SESSION['cart'];
        }
    }
?>