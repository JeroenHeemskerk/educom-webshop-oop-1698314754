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
    }
}
?>