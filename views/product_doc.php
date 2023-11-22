<?php

require_once "forms_doc.php";

abstract class ProductDoc extends FormsDoc {

    protected function showHeadContent() {
        parent::showHeadContent();
        echo '<script src="ratings.js"></script>';
    }
    
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

    protected function showBuyAction($buttonText) {
        $this->showFormStart();
            echo '<input type="hidden" name="page" value="cart">'; 
            echo '<input type="hidden" name="userAction" value="completeOrder">';
            echo '<input class="buyActionButton" type="submit" value="' . $buttonText . '">';
    }

    //Overridden showFormField voor DetaislDoc en WebshopDoc
    protected function showFormField($fieldName, $label, $inputType, $options = []) {
        echo '<label for="' . $fieldName . '">' . $label . '</label> ';
        echo '<input type="' . $inputType.'" id="' . $fieldName .  '" name="' . $fieldName . '" '; 
        echo 'value="" placeholder="' . $options . '">'; 
    }    
}
?>