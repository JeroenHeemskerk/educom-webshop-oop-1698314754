<?php

require_once "forms_doc.php";

class RegisterDoc extends FormsDoc {
    
    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Register</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        //Formulier met naam, emailadres en emailadrescheck
        showFormStart();
        showFormField("name", "Naam:", "text", $this->model->name, $this->model->errName, "John Doe");
        showFormField("email", "Emailadres:", "text", $this->model->email, $this->model->errMail, "johndoe@hotmail.com");
        showFormField("password", "Wachtwoord:", "password", $this->model->password, $this->model->errPassword, "");
        showFormField("passwordTwo", "Herhaal uw wachtwoord:", "password", $this->model->passwordTwo, "", "");
        
        //Verzendknop
        showFormEnd("register", "Registreer!");
    }
}
?>