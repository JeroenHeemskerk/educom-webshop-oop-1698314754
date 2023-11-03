<?php

require_once "forms_doc.php";

abstract class ProductDoc extends FormsDoc {
    
    protected function showAddToCartAction($productId, $page, $buttonText) {
        if ($this->model->sessionManager->isUserLoggedIn()) {
            $this->showFormStart();
            echo '<input type="hidden" name="page" value="' . $page . '">' .
            '<input type="hidden" name="productId" value="' . $productId . '">' .
            '<input type="hidden" name="userAction" value="addToCart">';
            $this->showFormField('quantity', 'Aantal', 'text', "", "", "0");
            echo '<input type="submit" value="' . $buttonText . '">';
            echo '</form>';
            echo '<br>';     
        }
    }
}
?>