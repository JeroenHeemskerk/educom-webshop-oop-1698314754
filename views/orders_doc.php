<?php

require_once "tables_doc.php";

class OrdersDoc extends TablesDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Orders</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Welkom!</h2>
        <p class="pagetext">Hier zullen uw orders in te zien zijn.</p>
        <br>';
    }

    /*
    private function showOrderAndRows($data) {

        echo '<h2>Bestelling: #' . $data['orderId'] . '</h2>';

        tableStart();

        rowStart();
            headerCell('');
            headerCell('Plaatje');
            headerCell('Product id');
            headerCell('Naam');
            headerCell('Hoeveelheid');
            headerCell('Prijs');
            headerCell('Totaal');
        rowEnd();

        $i = 1;
        foreach($data['rows'] as $value){
            rowStart();
                dataCell($i);
                dataCell('<img class="tablePicture" src="Images/' . $value['product_picture_location'] . '" alt="' . $value['product_picture_location'] . '">');
                dataCell($value['product_id']);
                dataCell($value['name']);
                dataCell($value['amount']);
                dataCell('€' . $value['price']);
                dataCell('€' . $value['total']);
            rowEnd();

            $i++;
        }

        rowStart();
            dataCell("", "", "", 6);
            dataCell('€' . $data['orders'][$data['orderId']]['total']);
        tableEnd();
    }

    private function showOrdersAndTotals($data) {

        echo '<h2>Uw bestellingen:</h2>';

        tableStart();

        rowStart();
            headerCell('Bestelling ID');
            headerCell('Totaal');
        rowEnd();
        
        foreach($data['orders'] as $value){
            rowStart();
                dataCell($value['order_id'], "orders", $value['order_id']);
                dataCell('€' . $value['total'], "orders", $value['order_id']);
            rowEnd();
        }

        tableEnd();
    }
    */
}
?>