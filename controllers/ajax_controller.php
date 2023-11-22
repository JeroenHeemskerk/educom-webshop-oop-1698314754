<?php

class AjaxController extends PageController {

    //Overridden constructor nu enkel $model geset hoeft te worden
    public function __construct($model){
        $this->model = $model;
    }
    

    public function handleAction() {
        $this->model->setAction();

        switch ($this->model->action) {
            case "averageratingbyproduct":
                $this->model->doGetAverageRatingByProductId();
                break;
            case "averageratings":
                $this->model->doGetAverageRatingForAllProducts();
                break;
            case "updaterating":
                $this->model->doUpdateRatingByProductIdForUserId();
                break;
            case "newrating":
                $this->model->doWriteRatingByProductIdForUserId();
                break;
        }
    }
}
?>