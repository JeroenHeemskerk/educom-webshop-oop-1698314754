<?php

class AjaxController {

    private $model;

    //Overridden constructor nu enkel $model geset hoeft te worden
    public function __construct($model){
        $this->model = $model;
    }    

    public function handleAction() {
        $this->model->setAction();

        switch ($this->model->action) {
            case "getRatingByProductId":
                $this->model->validateProductId();
                if ($this->model->valid){
                    $this->model->doGetAverageRatingByProductId();
                }
                break;
            case "getRatings":
                $this->model->doGetAverageRatingForAllProducts();
                break;
            case "setRating":
                $this->model->validateProductIdAndRating();
                if ($this->model->valid && $this->model->isRatingForProductByUserSet()) {
                    $this->model->doUpdateRatingByProductIdForUserId();
                } else if ($this->model->valid) {
                    $this->model->doWriteRatingByProductIdForUserId();
                }               
                break;
        }

        require_once "./views/ajax_doc.php";
        $view = new AjaxDoc($this->model);
        $view->response();
    }
}
?>