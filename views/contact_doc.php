<?php

require_once "forms_doc.php";

class ContactDoc extends FormsDoc {
    
    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Contact</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Contact pagina</h2>';
    }
}
?>