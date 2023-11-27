<?php

require_once "product_doc.php";

class WebshopDoc extends ProductDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Webshop</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>Ons assortiment</h2>' . PHP_EOL;
        echo '<br>' .  PHP_EOL;
        $this->showWebshopProducts();
    }
    
    private function showWebshopProducts() {
        echo '<span>' . $this->model->errProductId . '</span>' . PHP_EOL;
        echo '<span>' . $this->model->errQuantity . '</span>'.  PHP_EOL;

        //Geeft per product het product_id, name, description, price en product_picture_location weer
        foreach ($this->model->products as $key => $value){
            echo '<div class="starrating" data-product-id="' . $value->product_id . PHP_EOL . 
            '" data-user-id="' . $this->model->userId . '">Rating: ' . PHP_EOL .                       
                '<span class="star" data-value="1">*</span>' . PHP_EOL .
                '<span class="star" data-value="2">*</span>' . PHP_EOL .
                '<span class="star" data-value="3">*</span>' . PHP_EOL .
                '<span class="star" data-value="4">*</span>' . PHP_EOL .
                '<span class="star" data-value="5">*</span>' . PHP_EOL .
            '</div>' . PHP_EOL .
            '<a class="productlink" href="index.php?page=details&productId=' . $value->product_id . '"><div>' . PHP_EOL .
                'Product id: ' . $value->product_id . '<br>' . PHP_EOL .
                'Artikel: ' . $value->name . '<br>' .
                'Beschrijving: ' . $value->description . '<br>' . PHP_EOL .
                'Prijs: €' . $value->price . '<br>' . PHP_EOL .
                '<img src="Images/' . $value->product_picture_location . '" alt="' . $value->product_picture_location . '">' . PHP_EOL .
            '</div></a>' . PHP_EOL;

            $this->showAddToCartAction($value->product_id, 'webshop', 'Voeg toe aan winkelwagen');

            if ($key < $this->model->amountOfProducts) {
                echo '<hr>' . PHP_EOL;
            }
        }      
    }
}
?>