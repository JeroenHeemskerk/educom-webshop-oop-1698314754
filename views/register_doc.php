<?php

require_once "forms_doc.php";

class RegisterDoc extends FormsDoc {
    
    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Register</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Register pagina</h2>';
    }
}
?>