<?php

require_once "basic_doc.php";

class HomeDoc extends BasicDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Home</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Welkom!</h2>
        <p>Beste lezer,<br><br>
        Welkom op mijn website! De website is op dit moment nog onder constructie waardoor deze nog weinig functies kent en vrijwel geen informatie bevat. Hier komt spoedig verandering in.<br><br>
        Bedankt voor uw aandacht.</p>
        <br>';
    }
}
?>