<?php

require_once "./models/page_model.php";
require_once "./models/user_model.php";
require_once "./models/shop_model.php";

class PageController {

    private $model;

    public function __construct() {
        $this->model = new PageModel(NULL);
    }

    public function handleRequest() {
        $this->getRequest();
        $this->processRequest();
        $this->showResponse();
    }

    //from client
    private function getRequest() {
        $this->model->getRequestedPage();
    }

    //business flow code
    private function processRequest() {
        
        switch($this->model->page) {
            case "contact":
                $this->model = new UserModel($this->model);
                $this->model->validateContact();
                break;
            case "login":
                $this->model = new UserModel($this->model);
                $this->model->validateLogin();
                if ($this->model->valid) {
                    $this->model->doLoginUser($this->model->name, $this->model->email);
                    $this->model->setPage("home");
                }
                break;
            case "logout":
                $this->model = new UserModel($this->model);
                $this->model->doLogoutUser();
                $this->model->setPage("home");
                break;
            case "register":
                $this->model = new UserModel($this->model);
                $this->model->validateRegister();
                if ($this->model->valid) {
                    $this->model->setPage("login");
                }
                break;
            case "webshop":
                $this->model = new ShopModel($this->model);
                $this->model->getWebshopProducts();
                $this->model->handleActions();
                break;
            case "details":
                $this->model = new ShopModel($this->model);
                $this->model->getWebshopProductDetails();
                $this->model->handleActions();
                break;
            case "cart":
                $this->model = new ShopModel($this->model);
                $this->model->getCartLines();
                $this->model->handleActions();
                break;
            case "orders":
                $this->model = new ShopModel($this->model);
                $this->model->getRowsByOrderId();
                break;
        }
    }

    //to client
    private function showResponse() {
        $this->model->createMenu();

        switch($this->model->page) {
            case "home":
                require_once "./views/home_doc.php";
                $view = new HomeDoc($this->model);
                break;
            case "about":
                require_once "./views/about_doc.php";
                $view = new AboutDoc($this->model);
                break;
            case "contact":
                require_once "./views/contact_doc.php";
                $view = new ContactDoc($this->model);
                break;
            case "login":
                require_once "./views/login_doc.php";
                $view = new LoginDoc($this->model);
                break;
            case "register":
                require_once "./views/register_doc.php";
                $view = new RegisterDoc($this->model);
                break;
            case "webshop":
                require_once "./views/webshop_doc.php";
                $view = new WebshopDoc($this->model);
                break;
            case "details":
                require_once "./views/details_doc.php";
                $view = new DetailsDoc($this->model);
                break;
            case "cart":
                require_once "./views/cart_doc.php";
                $view = new CartDoc($this->model);
                break;
            case "orders":
                require_once "./views/orders_doc.php";
                $view = new OrdersDoc($this->model);
                break;
        }
        $view->show();
    }
}
?>