<?php

require_once "product_doc.php";

class DetailsDoc extends ProductDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Details</h1>' . PHP_EOL;
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>' . $this->model->product->name . '</h2>' . PHP_EOL;

        //Sterren worden hier aangemaakt voor het rating systeem
        echo '<div class="ratingtext">Rating: </div>' . PHP_EOL;
        echo '<div class="starrating" data-product-id="' . $this->model->product->productId . PHP_EOL . 
        '" data-user-id="' . $this->model->userId . '">' . PHP_EOL .                    
            '<span class="star" data-value="1">*</span>' . PHP_EOL .
            '<span class="star" data-value="2">*</span>' . PHP_EOL .
            '<span class="star" data-value="3">*</span>' . PHP_EOL .
            '<span class="star" data-value="4">*</span>' . PHP_EOL .
            '<span class="star" data-value="5">*</span>' . PHP_EOL .
        '</div>' . PHP_EOL;

        echo '<br>' . PHP_EOL;

        echo '<img src="Images/' . $this->model->product->productPictureLocation . '" class="detailPicture" alt="' . $this->model->product->productPictureLocation . '"><br>' . PHP_EOL .
        'Artikel: ' . $this->model->product->name . '<br>' . PHP_EOL .
        'Beschrijving: ' . $this->model->product->description . '<br>' . PHP_EOL .
        'Prijs: €' . $this->model->product->price . '<br>' . PHP_EOL;

        echo '<span>' . $this->model->errProductId . '</span><br>' . PHP_EOL .
        '<span>' . $this->model->errQuantity . '</span><br>' . PHP_EOL;

        $this->showAddToCartAction($this->model->product->productId, 'details', 'Voeg toe aan winkelwagen');
    }
}
?>