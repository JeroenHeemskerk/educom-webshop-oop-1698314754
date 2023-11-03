<?php

require_once "tables_doc.php";

class OrdersDoc extends TablesDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Bestellingen</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        if (!is_numeric($this->model->orderId)){
            $this->showOrdersAndTotals();
        } else {
            $this->showOrderAndRows();
        }
    }

    
    private function showOrderAndRows() {

        echo '<h2>Bestelling: #' . $this->model->orderId . '</h2>';

        $this->tableStart();

        $this->rowStart();
            $this->headerCell('');
            $this->headerCell('Plaatje');
            $this->headerCell('Product id');
            $this->headerCell('Naam');
            $this->headerCell('Hoeveelheid');
            $this->headerCell('Prijs');
            $this->headerCell('Totaal');
        $this->rowEnd();

        $i = 1;
        foreach($this->model->rows as $value){
            $this->rowStart();
                $this->dataCell($i);
                $this->dataCell('<img class="tablePicture" src="Images/' . $value['product_picture_location'] . '" alt="' . $value['product_picture_location'] . '">');
                $this->dataCell($value['product_id']);
                $this->dataCell($value['name']);
                $this->dataCell($value['amount']);
                $this->dataCell('€' . $value['price']);
                $this->dataCell('€' . $value['total']);
            $this->rowEnd();

            $i++;
        }

        $this->rowStart();
            $this->dataCell("", "", "", 6);
            $this->dataCell('€' . $this->model->orders[$this->model->orderId]['total']);
        $this->tableEnd();
    }

    private function showOrdersAndTotals() {

        echo '<h2>Uw bestellingen:</h2>';

        $this->tableStart();

        $this->rowStart();
            $this->headerCell('Bestelling ID');
            $this->headerCell('Totaal');
        $this->rowEnd();
        
        foreach($this->model->orders as $value){
            $this->rowStart();
                $this->dataCell($value['order_id'], "orders", $value['order_id']);
                $this->dataCell('€' . $value['total'], "orders", $value['order_id']);
            $this->rowEnd();
        }

        $this->tableEnd();
    }
}
?>