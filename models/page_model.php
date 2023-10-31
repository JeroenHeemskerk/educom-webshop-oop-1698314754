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
            $this->sessionManager = new SessionManager();
        } else {
            //called from the constructor of an extended class
            $this->page = $copy->page;
            $this->isPost = $copy->isPost;
            $this->menu = $copy->menu;
            $this->genericErr = $copy->genericErr;
            $this->sessionManager = $copy->sessionManager;
        }
    }

    public function getRequestedPage() {

        require_once "../util.php"

        $this->isPost = ($_SERVER['REQUEST_METHOD']) == 'POST');

        if ($this->isPost) {
            $this->setPage(Util::getPostVar("page", "home"));
        } else {
            $this->setPage($this->getUrlVar("page", "home"));
        }
    }

    protected function setPage($newPage) {
        $this->page = $newPage;
    }

    public function createMenu() {
        $this->menu['home'] = new MenuItem('home', 'Home');
        $this->menu['about'] = new MenuItem('about', 'About');
        $this->menu['contact'] = new MenuItem('contact', 'Contact');
        $this->menu['orders'] = new MenuItem('webshop', 'Webshop');
        
        if ($this->sessionManager->isUserLoggedIn()) {        
            $this->menu['register'] = new MenuItem('cart', 'Winkelwagen');
            $this->menu['home'] = new MenuItem('orders', 'Bestellingen');
            $this->menu['home'] = new MenuItem('logout', 'Logout',
                $this->sessionManager->getLoggedInUser());
        } else {
            $this->menu['home'] = new MenuItem('register', 'Register');
            $this->menu['home'] = new MenuItem('login', 'Login');
        }
    }


}

?>