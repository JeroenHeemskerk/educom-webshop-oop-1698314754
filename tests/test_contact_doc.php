<?php

    require_once "../views/contact_doc.php";

    $data = array ('page' => 'contact');
    
    $view = new ContactDoc($data);
    $view->show();
?>