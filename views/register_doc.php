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
        $this->showFormStart();
        $this->showFormField("name", "Naam:", "text", $this->model->name, $this->model->errName, "John Doe");
        $this->showFormField("email", "Emailadres:", "text", $this->model->email, $this->model->errMail, "johndoe@hotmail.com");
        $this->showFormField("password", "Wachtwoord:", "password", $this->model->password, $this->model->errPassword, "");
        $this->showFormField("passwordTwo", "Herhaal uw wachtwoord:", "password", $this->model->passwordTwo, "", "");
        
        //Verzendknop
        $this->showFormEnd("register", "Registreer!");
    }
}
?>