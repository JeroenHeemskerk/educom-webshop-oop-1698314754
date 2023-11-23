<?php

require_once "user_crud.php";
require_once "shop_crud.php";
require_once "rating_crud.php";

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
            case "shop":
                return new ShopCrud($this->crud);
                break;
            case "rating":
                return new RatingCrud($this->crud);
                break;
        }
    }
}
?>