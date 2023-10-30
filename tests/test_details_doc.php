<?php

    require_once "../views/details_doc.php";

    $data = array ('page' => 'details');
    
    $view = new DetailsDoc($data);
    $view->show();
?>