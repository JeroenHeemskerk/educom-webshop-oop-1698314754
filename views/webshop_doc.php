<?php

require_once "product_doc.php";

class WebshopDoc extends ProductDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Webshop</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Welkom!</h2>
        <p class="pagetext">Hier zal de webshop te vinden zijn.</p>
        <br>';
    }
}
?>