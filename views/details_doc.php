<?php

require_once "tables_doc.php";

class DetailsDoc extends TablesDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Details</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Welkom!</h2>
        <p class="pagetext">Hier komt de weergave van een product.</p>
        <br>';

        //showAddToCartAction($productId, $page, $buttonText);
    }
}
?>