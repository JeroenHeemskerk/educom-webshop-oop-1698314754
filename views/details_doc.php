<?php

require_once "product_doc.php";

class DetailsDoc extends ProductDoc {

    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Details</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {
        echo '<h2>' . $this->model->product->name . '</h2>';

        //Sterren worden hier aangemaakt voor het rating systeem
        echo '<div class="starrating" data-product-id="' . $this->model->product->product_id . 
        '" data-user-id="' . $this->model->userId . '">Rating: ';                       
        echo '<span class="star" data-value="1">*</span>';
        echo '<span class="star" data-value="2">*</span>';
        echo '<span class="star" data-value="3">*</span>';
        echo '<span class="star" data-value="4">*</span>';
        echo '<span class="star" data-value="5">*</span>';
        echo '</div>';

        echo '<br>';

        echo '<img src="Images/' . $this->model->product->product_picture_location . '" class="detailPicture" alt="' . $this->model->product->product_picture_location . '"><br>' .
        'Artikel: ' . $this->model->product->name . '<br>' .
        'Beschrijving: ' . $this->model->product->description . '<br>' .
        'Prijs: €' . $this->model->product->price . '<br>';

        echo '<span>' . $this->model->errProductId . '</span><br>' .
        '<span>' . $this->model->errQuantity . '</span><br>';

        $this->showAddToCartAction($this->model->product->product_id, 'details', 'Voeg toe aan winkelwagen');
    }
}
?>