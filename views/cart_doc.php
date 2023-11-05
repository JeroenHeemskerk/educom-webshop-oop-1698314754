<?php

require_once "tables_doc.php";

class CartDoc extends TablesDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Winkelwagen</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        if (!empty($this->model->cartLines)){
            $this->showTable();
            $this->showBuyAction('Koop nu!');
        } else {
            echo '<h2>Er is nog niets te tonen nu de winkelmand nog leeg is. U kunt in de webshop ' . 
            'iets toevoegen om aan te schaffen en dit op deze pagina afrekenen.</h2>';
        } 
    }

    function showTable() {

        $this->tableStart();

        $this->rowStart();
            $this->headerCell('Foto:'); 
            $this->headerCell('Product:');
            $this->headerCell('Beschrijving:');
            $this->headerCell('Prijs per stuk:');
            $this->headerCell('Hoeveelheid:');
            $this->headerCell('Subtotaal:');
        $this->rowEnd();
        
        foreach ($this->model->cartLines as $productId => $value){
            $this->rowStart();
                $this->dataCell('<img class="tablePicture" src="Images/' . $this->model->cartLines[$productId]['product_picture_location'] . '" alt="' . $this->model->cartLines[$productId]['product_picture_location'] . '">', "details", $productId);
                $this->dataCell($this->model->cartLines[$productId]['name'], "details", $productId);
                $this->dataCell($this->model->cartLines[$productId]['description'], "details", $productId);
                $this->dataCell('€' . $this->model->cartLines[$productId]['price']);
                $this->dataCell($this->model->cartLines[$productId]['amount']);
                $this->dataCell('€'. $this->model->cartLines[$productId]['subTotal']);
            $this->rowEnd();
        }
    
        $this->rowStart(); 
            $this->dataCell('', '', '', 4);
            $this->dataCell('Totaal:');  
            $this->dataCell('€' . $this->model->total);
        $this->rowEnd();
        
        $this->tableEnd();
    }
}
?>