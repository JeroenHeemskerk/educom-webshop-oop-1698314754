<?php

    require_once "../views/orders_doc.php";

    $data = array ('page' => 'orders');
    
    $view = new OrdersDoc($data);
    $view->show();
?>