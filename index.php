<?php
    session_start();
    require_once "./controllers/page_controller.php";
    require_once "crud.php";
    require_once "crud_factory.php";
    require_once "model_factory.php";

    $crud = new Crud();
    $crudFactory = new CrudFactory($crud);
    $modelFactory = new ModelFactory($crudFactory);
    $controller = new PageController($modelFactory);
    $controller->handleRequest();
    
    function logError($msg) {
        //echo 'Logging to errorlog: ' . $msg;
    }	
?>



