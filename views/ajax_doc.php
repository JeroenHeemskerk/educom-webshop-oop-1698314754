<?php
class AjaxDoc {
    private $data;

    public function __constructor($data) {
        $this->data = $data;
    }

    public function response() {
        $json = json_encode($this->data);
        echo $json;
    }
}
?>