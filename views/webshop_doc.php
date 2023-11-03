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

    
    /*protected function showAddToCartAction($productId, $page, $buttonText) {

    }*/
    
    private function showWebshopProducts() {

        $amountOfProducts = count($this->model->products);

        echo '<span>' . $this->model->errProductId . '</span>';
        echo '<span>' . $this->model->errQuantity . '</span>';

        //Geeft per product het product_id, name, description, price en product_picture_location weer 
        for ($i = 1; $i <= $amountOfProducts; $i++){
            echo '<a class="productlink" href="index.php?page=details&productId=' . $this->model->products[$i]['product_id'] . '"><div>' .
            'Product id: ' . $this->model->products[$i]['product_id'] . '<br>' .
            'Artikel: ' . $this->model->products[$i]['name'] . '<br>' .
            'Beschrijving: ' . $this->model->products[$i]['description'] . '<br>' .
            'Prijs: €' . $this->model->products[$i]['price'] . '<br>' .
            '<img src="Images/' . $this->model->products[$i]['product_picture_location'] . '" alt="' . $this->model->products[$i]['product_picture_location'] . '">' .
            '</div></a>';
            
            $this->showAddToCartAction($this->model->products[$i]['product_id'], 'webshop', 'Voeg toe aan winkelwagen');
        }
            
    }
    
}
?>