<?php

class AjaxController {

    private $model;

    //Overridden constructor nu enkel $model geset hoeft te worden
    public function __construct($model){
        $this->model = $model;
    }    

    public function handleAction() {
        $this->model->setAction();

        require_once "./views/ajax_doc.php";
        $view = new AjaxDoc($this->model);

        switch ($this->model->action) {
            case "averageratingbyproduct":
                $this->model->validateProductId();
                if ($this->model->valid){
                    $this->model->doGetAverageRatingByProductId();
                }
                $view->response();
                break;
            case "averageratings":
                $this->model->doGetAverageRatingForAllProducts();
                $view->response();
                break;
            case "updaterating":
                $this->model->validateProductIdAndRating();
                if ($this->model->valid){
                    $this->model->doUpdateRatingByProductIdForUserId();
                }
                $view->response();
                break;
            case "newrating":
                $this->model->validateProductIdAndRating();
                if ($this->model->valid){
                $this->model->doWriteRatingByProductIdForUserId();
                }
                $view->response();
                break;
        }
    }
}
?>