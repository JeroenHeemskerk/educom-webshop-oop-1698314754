<?php

require_once "../models/page_model.php";

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
    private getRequest() {
        $this->model->getRequestedPage();
    }

    //business flow code
    private processRequest() {
        /*switch($this->model->page) {

            case "about":
                $this->model = new PageModel();
                break;
            default:
                $this->model = new PageModel();
        }*/
    }

    //to client
    private function showResponse() {
        $this->model->createMenu();

        switch($this->model->page) {
            case "home":
                require_once "../views/home_doc.php";
                $view = new HomeDoc($this->model);
                break;
            case "about":
                require_once "../views/about_doc.php";
                $view = new AboutDoc($this->model);
                break;
        }
        $view->show();
    }
}
?>