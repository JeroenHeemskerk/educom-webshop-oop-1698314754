<?php
class AjaxDoc {
    private AjaxModel $model;

    public function __constructor($model) {
        $this->model = $model;
    }

    public function response() {
        $json = json_encode($this->model->data);
        echo $json;
    }
}
?>