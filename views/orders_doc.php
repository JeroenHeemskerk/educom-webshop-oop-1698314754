<?php

require_once "tables_doc.php";

class OrdersDoc extends TablesDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Orders</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Welkom!</h2>
        <p class="pagetext">Hier zullen uw orders in te zien zijn.</p>
        <br>';
    }
}
?>