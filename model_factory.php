<?php
class ModelFactory {
    private CrudFactory $crudFactory;
    private $lastModel;

    public function __construct($crudFactory) {
        $this->crudFactory = $crudFactory;
    }

    public function createModel($name) {

        switch ($name) {
            case "page":
                $this->lastModel = new PageModel($this->lastModel);
                break;
            case "user":
                $modelCrud = $this->crudFactory->createCrud($name);
                $this->lastModel = new UserModel($this->lastModel, $modelCrud);
                break;
            case "shop":
                $modelCrud = $this->crudFactory->createCrud($name);
                $this->lastModel = new ShopModel($this->lastModel, $modelCrud);
                break;
            case "ajax":
                $modelCrud = $this->crudFactory->createCrud("rating");
                $this->lastModel = new AjaxModel($this->lastModel, $modelCrud);
                break;
       }

       return $this->lastModel;
    }
}
?>