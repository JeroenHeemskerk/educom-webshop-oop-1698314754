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

    /*
    private function showBuyAction($buttonText) {
        showFormStart();
            echo '<input type="hidden" name="page" value="cart">'; 
            echo '<input type="hidden" name="userAction" value="completeOrder">';
            echo '<input class="buyActionButton" type="submit" value="' . $buttonText . '">';
    }
    */
}
?>