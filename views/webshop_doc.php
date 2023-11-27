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
        $this->showWebshopProducts();
    }
    
    private function showWebshopProducts() {
        echo '<span>' . $this->model->errProductId . '</span>' . PHP_EOL;
        echo '<span>' . $this->model->errQuantity . '</span>'.  PHP_EOL;

        //Geeft per product het productId, name, description, price en productPictureLocation weer
        foreach ($this->model->products as $key => $value){
            echo '<div class="starrating" data-product-id="' . $value->productId . PHP_EOL . 
            '" data-user-id="' . $this->model->userId . '">Rating: ' . PHP_EOL .                       
                '<span class="star" data-value="1">*</span>' . PHP_EOL .
                '<span class="star" data-value="2">*</span>' . PHP_EOL .
                '<span class="star" data-value="3">*</span>' . PHP_EOL .
                '<span class="star" data-value="4">*</span>' . PHP_EOL .
                '<span class="star" data-value="5">*</span>' . PHP_EOL .
            '</div>' . PHP_EOL .
            '<a class="productlink" href="index.php?page=details&productId=' . $value->productId . '"><div>' . PHP_EOL .
                'Product id: ' . $value->productId . '<br>' . PHP_EOL .
                'Artikel: ' . $value->name . '<br>' .
                'Beschrijving: ' . $value->description . '<br>' . PHP_EOL .
                'Prijs: €' . $value->price . '<br>' . PHP_EOL .
                '<img src="Images/' . $value->productPictureLocation . '" alt="' . $value->productPictureLocation . '">' . PHP_EOL .
            '</div></a>' . PHP_EOL;

            $this->showAddToCartAction($value->productId, 'webshop', 'Voeg toe aan winkelwagen');

            if ($key < $this->model->amountOfProducts) {
                echo '<hr>' . PHP_EOL;
            }
        }      
    }
}
?>