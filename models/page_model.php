<?php

class PageModel {
    public $page;
    protected $isPost = False;
    public $menu;
    public $errors = array();
    public $genericError = "";
    protected $sessionManager;

    public function __construct($copy) {
        if (empty($copy)) {
            //first instance of PageModel
            $this->sessionManager = new SessionManager();
        } else {
            //Deze wordt gebruikt wanneer een extended class de constructor in deze class aanroept
            $this->page = $copy->page;
            $this->isPost = $copy->isPost;
            $this->menu = $copy->menu;
            $this->genericError = $copy->genericError;
            $this->sessionManager = $copy->sessionManager;
        }
    }

    public function getRequestedPage() {

        require_once "./util.php";

        $this->isPost = (($_SERVER['REQUEST_METHOD']) == 'POST');
        
        //Hier worden static functies uit de Util class gebruikt om page te setten
        if ($this->isPost) {
            $this->setPage(Util::getPostVar("page", "home"));
        } else {
            $this->setPage(Util::getUrlVar("page", "home"));
        }
    }

    public function setPage($newPage) {
        //Was eerst protected, maar ik moest hem in page_controller aanroepen
        $this->page = $newPage;
    }

    public function createMenu() {
        require_once "./session_manager.php";
        //Werkte eerst door middel van een nieuwe instantie van MenuItem, maar deze class heb ik nog niet aangemaakt
        $this->menu = array('home' => 'Home');
        $this->menu += array('about' => 'About');
        $this->menu += array('contact' => 'Contact');
        $this->menu += array('webshop' => 'Webshop');
        
        if ($this->sessionManager->isUserLoggedIn()) {        
            $this->menu += array('cart' => 'Winkelwagen');
            $this->menu += array('orders' => 'Bestellingen');
            $this->menu += array('logout' => 'Logout ' .
                $this->sessionManager->getLoggedInUserName());
        } else {
            $this->menu += array('register' => 'Register');
            $this->menu += array('login' => 'Login');
        }
    }
}

?>