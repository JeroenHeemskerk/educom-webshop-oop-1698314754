<?php

require_once "product_doc.php";

class WebshopDoc extends ProductDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Webshop</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Welkom!</h2>
        <p class="pagetext">Hier zal de webshop te vinden zijn.</p>
        <br>';
    }

    /*
    protected function showAddToCartAction($productId, $page, $buttonText) {

    }
    */

    /*
    private function showWebshopProducts($data) {

        $amountOfProducts = count($data['products']);

        echo '<span>' . $data['errProductId'] . '</span>';
        echo '<span>' . $data['errQuantity'] . '</span>';

        //Geeft per product het product_id, name, description, price en product_picture_location weer 
        for ($i = 1; $i <= $amountOfProducts; $i++){
            echo '<a class="productlink" href="index.php?page=details&productId=' . $data['products'][$i]['product_id'] . '"><div>' .
            'Product id: ' . $data['products'][$i]['product_id'] . '<br>' .
            'Artikel: ' . $data['products'][$i]['name'] . '<br>' .
            'Beschrijving: ' . $data['products'][$i]['description'] . '<br>' .
            'Prijs: €' . $data['products'][$i]['price'] . '<br>' .
            '<img src="Images/' . $data['products'][$i]['product_picture_location'] . '" alt="' . $data['products'][$i]['product_picture_location'] . '">' .
            '</div></a>';
            
            showAddToCartAction($data['products'][$i]['product_id'], 'webshop', 'Voeg toe aan winkelwagen');
        }
            
    }
    */
}
?>