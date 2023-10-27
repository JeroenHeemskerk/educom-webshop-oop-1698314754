<?php
    
	function getRegisterHeader() {
        return "Register";
    }
    
    function showRegisterBody($data){
        
        //Formulier met naam, emailadres en emailadrescheck
        showFormStart();
        showFormField("name", "Naam:", "text", $data['name'], $data['errName'], "John Doe");
        showFormField("email", "Emailadres:", "text", $data['email'], $data['errMail'], "johndoe@hotmail.com");
        showFormField("password", "Wachtwoord:", "password", $data['password'], $data['errPassword'], "");
        showFormField("passwordTwo", "Herhaal uw wachtwoord:", "password", $data['passwordTwo'], "", "");
        
        //Verzendknop
        showFormEnd("register", "Registreer!");
    }
?>