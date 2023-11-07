<?php

require_once "user_crud.php";

class CrudFactory {
    private Crud $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function createCrud($name) {
        switch ($name){
            case "user":
                return new UserCrud($this->crud);
                break;
        }
    }
}
?>