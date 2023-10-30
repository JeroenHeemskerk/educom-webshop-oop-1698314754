<?php

    require_once "../views/login_doc.php";

    $data = array ('page' => 'login');
    
    $view = new LoginDoc($data);
    $view->show();
?>