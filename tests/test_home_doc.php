<?php

    require_once "../views/home_doc.php";

    $data = array ('page' => 'home');
    
    $view = new HomeDoc();
    $view -> show();
?>