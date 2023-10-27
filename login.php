<?php
    
	function getLoginHeader() {
        return "Login";
    }
    
    function showLoginBody($data){
        
        //Inlogformulier welke om een emailadres en een wachtwoord verzoekt
        showFormStart();

        showFormField("email", "Vul uw emailadres in:", "text", $data['email'], $data['errMail'], "johndoe@hotmail.com");
        showFormField("password", "Vul uw wachtwoord in:", "password", "", $data['errPassword']);

        showFormEnd("login", "Login");
    }
    
    
?>