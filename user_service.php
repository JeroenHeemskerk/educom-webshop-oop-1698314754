<?php
    
    function storeUser($email, $name, $password){
        registerNewAccount($name, $email, $password);
    }

    function authenticateUser($email, $password) {
        $user = findUserByEmail($email);
        if (empty($user)) {
            return NULL;
        }
        if ($password != $user['password']) {
            return NULL;
        }
        return $user;
    }
    
    function doesEmailExist($email) {
        return !empty(findUserByEmail($email));
    } 
       
?>