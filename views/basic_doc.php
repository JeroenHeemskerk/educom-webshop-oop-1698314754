<?php

require_once "html_doc.php";

class BasicDoc extends HtmlDoc {

    protected $model;

    function __construct($model) {
        $this->model = $model;
    }

    //Overridden method van HtmlDoc
    protected function showHeadContent() {
        $this->showTitle();
        $this->showCssLinks();
    }

    private function showTitle() {
        echo '<title>' . $this->model->page . '</title>' . PHP_EOL;
    }

    private function showCssLinks() {
        echo '<link rel="stylesheet" href="./CSS/stylesheet.css">' . PHP_EOL;
    }

    //Overridden method of HtmlDoc
    protected function showBodyContent() {
        $this->showHeader();
        $this->showMenu();
        $this->showContent();
        $this->showFooter();
    }

    protected function showHeader() {
        echo '<h1>Basic</h1>' . PHP_EOL;
    }

    private function showMenu() {
        echo '<ul class="nav">' . PHP_EOL;        
        foreach($this->model->menu as $page => $label) {
            echo '<li><a href="index.php?page=' . $page . '">' . $label . '</a></li>';
        }
        echo '</ul><br>' . PHP_EOL;
        echo $this->model->genericError;
    }

    protected function showContent() {
        echo '<p class="pagetext">Dit is de basispagina.</p>' . PHP_EOL;
    }

    private function showFooter() {
        echo '<footer><p>&copy 2023<br>Nick Koole</p></footer>' . PHP_EOL;
    }
}
?>