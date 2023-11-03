<?php

require_once "forms_doc.php";

class LoginDoc extends FormsDoc {
    
    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Login</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {

        $this->showFormStart();

        $this->showFormField("email", "Vul uw emailadres in:", "text", "johndoe@hotmail.com");
        $this->showFormField("password", "Vul uw wachtwoord in:", "password");

        $this->showFormEnd("login", "Login");
    }
}
?>