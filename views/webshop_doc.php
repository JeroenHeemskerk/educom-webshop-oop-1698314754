<?php

require_once "product_doc.php";

class WebshopDoc extends ProductDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Webshop</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Ons assortiment</h2>';
        echo '<br>';
        $this->showWebshopProducts();
    }
    
    private function showWebshopProducts() {
        echo '<span>' . $this->model->errProductId . '</span>';
        echo '<span>' . $this->model->errQuantity . '</span>';

        //Geeft per product het product_id, name, description, price en product_picture_location weer
        foreach ($this->model->products as $key => $value){
            echo '<a class="productlink" href="index.php?page=details&productId=' . $value->product_id . '"><div>' .
            'Product id: ' . $value->product_id . '<br>' .
            'Artikel: ' . $value->name . '<br>' .
            'Beschrijving: ' . $value->description . '<br>' .
            'Prijs: €' . $value->price . '<br>' .
            '<img src="Images/' . $value->product_picture_location . '" alt="' . $value->product_picture_location . '">' .
            '</div></a>';

            $this->showAddToCartAction($value->product_id, 'webshop', 'Voeg toe aan winkelwagen');
        }      
    }
}
?>