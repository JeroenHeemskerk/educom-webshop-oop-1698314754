<?php

require_once "./models/page_model.php";
require_once "./models/user_model.php";

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
        }
        $view->show();
    }
}
?>