<?php

    require_once "../views/basic_doc.php";

    $data = array ('page' => 'basic');
    
    $view = new BasicDoc();
    $view -> show();
?>