<?php
class UserCrud {
    private Crud $crud;

    public function __construct($crud) {
        $this->crud = $crud;
    }

    public function createUser($name, $email, $password) {
        $sql = "INSERT INTO users (name, email_address, password)
        VALUES (:name, :email, :password)";
        $values = array("name" => $name, "email" => $email, "password" => $password);

        //$values moet een associatieve array zijn met name, email en password
        $this->crud->createRow($sql, $values);
    }

    public function readUserByEmail($email) {
        $sql = "SELECT name, email_address, password FROM users WHERE email_address = :email";
        $email = array("email" => $email);

        //$email moet een associatieve array zijn: "email" => "voorbeeld@v.v"
        $user = $this->crud->readOneRow($sql, $email);
        return $user;
    }
}
?>