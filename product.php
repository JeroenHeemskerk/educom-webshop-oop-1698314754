<?php
    
	function getProductHeader() {
        return "Product";
    }
    
    function showProductBody($data) {
                
        echo '<h2>' . $data['product']["name"] . '</h2>';

        echo '<img src="Images/' . $data['product']["product_picture_location"] . '" class="detailPicture" alt="' . $data['product']["product_picture_location"] . '"><br>' .
        'Artikel: ' . $data['product']["name"] . '<br>' .
        'Beschrijving: ' . $data['product']["description"] . '<br>' .
        'Prijs: €' . $data['product']["price"] . '<br>';

        echo '<span>' . $data['errProductId'] . '</span><br>' .
        '<span>' . $data['errQuantity'] . '</span><br>';

        showAddToCartAction($data['product']['product_id'], 'details', 'Voeg toe aan winkelwagen');
    }
?>