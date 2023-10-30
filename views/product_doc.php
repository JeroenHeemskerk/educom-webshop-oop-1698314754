<?php

require_once "basic_doc.php";

abstract class ProductDoc extends BasicDoc {
    if (isUserLoggedIn()) {
        showFormStart();
        echo '<input type="hidden" name="page" value="' . $page . '">' .
        '<input type="hidden" name="productId" value="' . $productId . '">' .
        '<input type="hidden" name="userAction" value="addToCart">';
        showFormField('quantity', 'Aantal', 'text', "", "", "0");
        echo '<br>';
        echo '<input type="submit" value="' . $buttonText . '">';
        echo '</form>';     
    }
}
?>