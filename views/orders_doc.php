<?php

require_once "tables_doc.php";

class OrdersDoc extends TablesDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Bestellingen</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        if (!is_numeric($this->model->orderId) && $this->model->orders != null) {
            $this->showOrdersAndTotals();
        } else if (is_numeric($this->model->orderId) && $this->model->order != null) {
            $this->showOrderAndRows();
        } else {
            echo '<h2>Er zijn geen eerdere bestellingen om weer te geven</h2>';
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
                $this->dataCell('<img class="tablePicture" src="Images/' . $value->productPictureLocation . '" alt="' . $value->productPictureLocation . '">');
                $this->dataCell($value->productId);
                $this->dataCell($value->name);
                $this->dataCell($value->amount);
                $this->dataCell('€' . $value->price);
                $this->dataCell('€' . $value->total);
            $this->rowEnd();
            $i++;
        }

        $this->rowStart();
            $this->dataCell("", "", "", "", 6);
            $this->dataCell('€' . $this->model->order->total);
        $this->tableEnd();
    }

    private function showOrdersAndTotals() {

        echo '<h2>Uw bestellingen:</h2>';

        $this->tableStart();

        $this->rowStart();
            $this->headerCell('Bestelling ID');
            $this->headerCell('Totaal');
        $this->rowEnd();
        
        foreach($this->model->orders as $order){
            $this->rowStart();
                $this->dataCell($order->orderId, "orders", $order->orderId, 'orderId');
                $this->dataCell('€' . $order->total, "orders", $order->orderId, 'orderId');
            $this->rowEnd();
        }

        $this->tableEnd();
    }
}
?>