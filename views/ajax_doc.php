<?php

class AjaxDoc extends BasicDoc {

    public function response() {
        echo $this->model->json;
    }
}