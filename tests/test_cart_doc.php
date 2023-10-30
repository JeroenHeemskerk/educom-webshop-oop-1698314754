<?php

    require_once "../views/cart_doc.php";

    $data = array ('page' => 'cart');
    
    $view = new CartDoc($data);
    $view->show();
?>