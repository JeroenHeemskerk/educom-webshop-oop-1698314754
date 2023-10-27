<?php

    function getCartHeader() {
        return "Winkelwagen";
    }

    function showCartBody($data) {

        if (!empty($data['cartLines'])){
            showTable($data);
            showBuyAction('Koop nu!');
        } else {
            echo '<h2>Er is nog niets te tonen nu de winkelmand nog leeg is. U kunt in de webshop ' . 
            'iets toevoegen om aan te schaffen en dit op deze pagina afrekenen.</h2>';
        }        
    }

    function showTable($data) {

        tableStart();

        rowStart();
            headerCell('Foto:'); 
            headerCell('Product:');
            headerCell('Beschrijving:');
            headerCell('Prijs per stuk:');
            headerCell('Hoeveelheid:');
            headerCell('Subtotaal:');
        rowEnd();
        
        foreach ($data['cartLines'] as $productId => $value){
            rowStart();
                dataCell('<img class="tablePicture" src="Images/' . $data['cartLines'][$productId]['product_picture_location'] . '" alt="' . $data['cartLines'][$productId]['product_picture_location'] . '">', "cart", $productId);
                dataCell($data['cartLines'][$productId]['name'], "cart", $productId);
                dataCell($data['cartLines'][$productId]['description'], "cart", $productId);
                dataCell('€' . $data['cartLines'][$productId]['price']);
                dataCell($data['cartLines'][$productId]['amount']);
                dataCell('€'. $data['cartLines'][$productId]['subTotal']);
            rowEnd();
        }
    
        rowStart(); 
            dataCell('', '', '', 4);
            dataCell('Totaal:');  
            dataCell('€' . $data['total']);
        rowEnd();
        
        tableEnd();
    }
?>