<?php

require_once "tables_doc.php";

class CartDoc extends TablesDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Winkelwagen</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Welkom!</h2>
        <p class="pagetext">Hier komt uw winkelwagentje.</p>
        <br>';
    }
}
?>