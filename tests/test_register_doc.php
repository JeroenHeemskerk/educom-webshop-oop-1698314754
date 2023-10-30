<?php

    require_once "../views/register_doc.php";

    $data = array ('page' => 'register');
    
    $view = new RegisterDoc($data);
    $view->show();
?>