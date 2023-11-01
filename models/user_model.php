<?php

class UserModel extends PageModel {
    public $contactmode, $email, $message, $name, $password, $passwordTwo, $phonenumber;
    public $productId, $quantity, $salutation;

    public $errContactmode, $errMail, $errMessage, $errName, $errPassword, $errPhonenumber;
    public $errProductId, $errQuantity, $errSalutation = "";

    private $userId = "";
    public $valid = False;

    public function __construct($pageModel) {
        parent::__construct($pageModel);
    }

    public function doLoginUser() {

    }

    public function doLogoutUser() {

    }

    private function authenticateUser() {

    }

}

?>