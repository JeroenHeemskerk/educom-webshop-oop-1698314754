<?php

    require_once "../views/webshop_doc.php";

    $data = array ('page' => 'webshop');
    
    $view = new WebshopDoc($data);
    $view->show();
?>