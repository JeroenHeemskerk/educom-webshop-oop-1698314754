<?php

require_once "forms_doc.php";

abstract class ProductDoc extends FormsDoc {

    //Overridden method van BasicDoc
    protected function showHeadContent() {
        parent::showHeadContent();
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>' . PHP_EOL;
        echo '<script src="./ratings.js"></script>' . PHP_EOL;
    }
    
    protected function showAddToCartAction($productId, $page, $buttonText) {
        if ($this->model->sessionManager->isUserLoggedIn()) {
            $this->showFormStart();
            echo '<input type="hidden" name="page" value="' . $page . '">' . PHP_EOL .
            '<input type="hidden" name="productId" value="' . $productId . '">' . PHP_EOL .
            '<input type="hidden" name="userAction" value="addToCart">' . PHP_EOL;
            $this->showFormField('quantity', 'Aantal', 'text', "", "", "0") . PHP_EOL;
            echo '<input type="submit" value="' . $buttonText . '">' . PHP_EOL;
            echo '</form>' . PHP_EOL;
            echo '<br>' . PHP_EOL;     
        }
    }

    protected function showBuyAction($buttonText) {
        $this->showFormStart();
            echo '<input type="hidden" name="page" value="cart">' . PHP_EOL; 
            echo '<input type="hidden" name="userAction" value="completeOrder">' . PHP_EOL;
            echo '<input class="buyActionButton" type="submit" value="' . $buttonText . '">' . PHP_EOL;
    }

    //Overridden showFormField voor DetaislDoc en WebshopDoc
    protected function showFormField($fieldName, $label, $inputType, $options = []) {
        echo '<label for="' . $fieldName . '">' . $label . '</label> ' . PHP_EOL;
        echo '<input type="' . $inputType.'" id="' . $fieldName .  '" name="' . $fieldName . '" ' . PHP_EOL; 
        echo 'value="" placeholder="' . $options . '">' . PHP_EOL; 
    }    
}
?>