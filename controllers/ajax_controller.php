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
            case "averageRatingByProduct":
                //$this->model->validateProductId();
                //if ($this->model->valid){
                    $this->model->doGetAverageRatingByProductId();
                //}
                break;
            case "averageRatings":
                $this->model->doGetAverageRatingForAllProducts();
                break;
            case "updateRating":
                $this->model->validateProductIdAndRating();
                if ($this->model->valid){
                    $this->model->doUpdateRatingByProductIdForUserId();
                }                
                break;
            case "newRating":
                $this->model->validateProductIdAndRating();
                if ($this->model->valid){
                $this->model->doWriteRatingByProductIdForUserId();
                }
                break;
        }

        require_once "./views/ajax_doc.php";
        $view = new AjaxDoc($this->model->data);
        $view->response();
    }
}
?>