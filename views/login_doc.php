<?php

require_once "forms_doc.php";

class LoginDoc extends FormsDoc {
    
    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Login</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Login pagina</h2>';
        showFormStart();

        showFormField("email", "Vul uw emailadres in:", "text", $data['email'], $data['errMail'], "johndoe@hotmail.com");
        showFormField("password", "Vul uw wachtwoord in:", "password", "", $data['errPassword']);

        showFormEnd("login", "Login");
    }
}
?>