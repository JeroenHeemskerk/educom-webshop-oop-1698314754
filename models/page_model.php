<?php

class PageModel {
    public $page;
    protected $isPost = False;
    public $menu;
    public $errors = array();
    public $genericErr = "";
    protected $sessionManager;

    public function __construct($copy) {
        if (empty($copy)) {
            //first instance of PageModel
            //Er is nog geen SessionManager class dus kan deze nog niet aanroepen
            //$this->sessionManager = new SessionManager();
        } else {
            //Deze wordt gebruikt wanneer een extended class de constructor in deze class aanroept
            $this->page = $copy->page;
            $this->isPost = $copy->isPost;
            $this->menu = $copy->menu;
            $this->genericErr = $copy->genericErr;
            $this->sessionManager = $copy->sessionManager;
        }
    }

    public function getRequestedPage() {

        require_once "./util.php";

        $this->isPost = (($_SERVER['REQUEST_METHOD']) == 'POST');
        
        //Hier worden static functies uit de Util class gebruikt
        if ($this->isPost) {
            $this->setPage(Util::getPostVar("page", "home"));
        } else {
            $this->setPage(Util::getUrlVar("page", "home"));
        }
    }

    protected function setPage($newPage) {
        $this->page = $newPage;
    }

    public function createMenu() {
        //Werkte eerst door middel van een nieuwe instantie van MenuItem, maar deze class heb ik nog niet aangemaakt
        $this->menu = array('home' => 'Home');
        $this->menu += array('about' => 'About');
        $this->menu += array('contact' => 'Contact');
        $this->menu += array('webshop' => 'Webshop');
        
        //if ($this->sessionManager->isUserLoggedIn()) {        
            //$this->menu += array('cart' => 'Winkelwagen');
            //$this->menu += array('orders' => 'Bestellingen');
            //$this->menu += array('logout' => 'Logout',
                //$this->sessionManager->getLoggedInUser());
        //} else {
            $this->menu += array('register' => 'Register');
            $this->menu += array('login' => 'Login');
        }
}

?>