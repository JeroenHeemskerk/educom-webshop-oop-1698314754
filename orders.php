<?php

    function getOrdersHeader() {
        return "Bestellingen";
    }

    function showOrdersBody($data) {
        
        if (!isset($data['orderId'])){
            showOrdersAndTotals($data);
        } else {
            showOrderAndRows($data);
        }
    }

    function showOrderAndRows($data) {

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

    function showOrdersAndTotals($data) {

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
?>