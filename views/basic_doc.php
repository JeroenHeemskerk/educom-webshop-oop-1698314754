<?php

require_once "html_doc.php";

class BasicDoc extends HtmlDoc {

    protected $model;

    function __construct($model) {
        $this->model = $model;
    }

    //Overridden method of HtmlDoc
    protected function showHeadContent() {
        $this->showTitle();
        $this->showCssLinks();
    }

    private function showTitle() {
        echo '<title>' . $this->model->page . '</title>';
    }

    private function showCssLinks() {
        echo '<link rel="stylesheet" href="./CSS/stylesheet.css">';
    }

    //Overridden method of HtmlDoc
    protected function showBodyContent() {
        $this->showHeader();
        $this->showMenu();
        $this->showContent();
        $this->showFooter();
    }

    protected function showHeader() {
        echo '<h1>Basic</h1>';
    }

    private function showMenu() {
        echo '<ul class="nav">';        
        foreach($this->model->menu as $page => $label) {
            echo '<li><a href="index.php?page=' . $page . '">' . $label . '</a></li>';
        }
        echo '</ul><br>';
        echo $this->model->genericError;
    }

    protected function showContent() {
        echo '<p class="pagetext">Dit is de basispagina.</p>';
    }

    private function showFooter() {
        echo '<footer><p>&copy 2023<br>Nick Koole</p></footer>';
    }
}
?>