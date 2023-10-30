<?php

require_once "html_doc.php";

class BasicDoc extends HtmlDoc {

    public $data;

    function __construct() {

    }

    //Overridden method of HtmlDoc
    protected function showHeadContent() {
        $this -> showTitle();
        $this -> showCssLinks();
    }

    private function showTitle() {
        echo '<title>Basic</title>';
    }

    private function showCssLinks() {
        echo '<link rel="stylesheet" href="../CSS/stylesheet.css">';
    }

    //Overridden method of HtmlDoc
    protected function showBodyContent() {
        $this -> showHeader();
        $this -> showMenu();
        $this -> showContent();
        $this -> showFooter();
    }

    protected function showHeader() {
        echo '<h1>Basic</h1>';
    }

    private function showMenu() {
        echo '<h2>Hier hoort een menu te staan</h2>';
    }

    protected function showContent() {
        echo '<p>Deze pagina is basic</p>';
    }

    private function showFooter() {
        echo '<footer><p>&copy 2023<br>Nick Koole</p></footer>';
    }
}
?>