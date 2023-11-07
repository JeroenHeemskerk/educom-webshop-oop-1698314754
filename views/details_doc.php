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