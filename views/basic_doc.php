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
        $data['menu'] = array('home' => 'Home', 'about' => 'About', 'contact' => 'Contact', 'webshop' => 'Webshop');
        if (false /*isUserLoggedIn()*/) {
            $data['menu']['cart'] = "Winkelwagen";
            $data['menu']['orders'] = "Bestellingen";
            $data['menu']['logout'] = "Logout "; // . getLoggedInUserName();
        } else {
            $data['menu']['register'] = "Register";
            $data['menu']['login'] = "Login";
        }

        echo '<ul class="nav">';        
        foreach($data['menu'] as $page => $label) {
            
            //Dit geeft uiteraard nog geen correcte links
            echo '<li><a href="index.php?page=' . $page . '">' . $label . '</a></li>';
        }
        echo '</ul><br>';
    }

    protected function showContent() {
        echo '<p class="pagetext">Dit is de basispagina.</p>';
    }

    private function showFooter() {
        echo '<footer><p>&copy 2023<br>Nick Koole</p></footer>';
    }
}
?>