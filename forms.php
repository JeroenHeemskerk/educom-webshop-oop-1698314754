<?php

    function showFormField($fieldName, $label, $inputType, $data, $error, $options = "") {        
		
        switch ($inputType){
            case("select"):
                if ($data['salutation'] == $options){
                    echo '<option value="' . $options . '" selected>' . $label . '</option>';
                } else {
                    echo '<option value="' . $options. '">' . $label . '</option>';
                }
                break;
            case ("text"):
                echo '<label for="' . $fieldName . '">' . $label . '</label> ';
                echo '<input type="text" id="' . $fieldName .  '" name="' . $fieldName . '"';
                echo 'value="' . $data . '" placeholder="' . $options . '">';
                showErrorSpan($error);
                break;
            case ("password"):
                echo '<label for="' . $fieldName . '">' . $label . '</label> ';
                echo '<input type="password" id="' . $fieldName .  '" name="' . $fieldName . '"';
                echo 'value="' . $data . '">';
                showErrorSpan($error);
                break;
            case ("radio"):
                if ($data['contactmode'] == $options){
                    echo '<input type="radio" checked = "checked" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $options . '">';
                    echo '<label for="' . $fieldName . '">' . $label . '</label><br>';
                } else {
                    echo '<input type="radio" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $options . '">';
                    echo '<label for="' . $fieldName . '">' . $label . '</label><br>';
                }
                break;
            case ("textarea"):
                echo '<label for="' . $fieldName . '">' . $label . '</label>';
                $this->showErrorSpan($data['errMessage']);
                echo '<textarea id="' . $fieldName . '" name="' . $fieldName . '"' . $options . '">'; echo $data['message'] . '</textarea>';
            }
    }

    function showErrorSpan($error) {
        echo '<span> ' . $error . '</span>';
        echo '<br>';
    }

    function showFormStart() {
        echo '<br><form method="post" action="index.php">'; 
    }
        
    function showFormEnd($page, $value) {
        //Verborgen variabele om ervoor te zorgen dat de pagina gevonden kan worden middels de getRequestedPage functie van index.php
        echo '<input type="hidden" name="page" value="' . $page . '">';
        echo '<input type="submit" value="' . $value . '">';
        echo '</form>';
    }

    function showAddToCartAction($productId, $page, $buttonText) {
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

    function showBuyAction($buttonText) {
        showFormStart();
            echo '<input type="hidden" name="page" value="cart">'; 
            echo '<input type="hidden" name="userAction" value="completeOrder">';
            echo '<input class="buyActionButton" type="submit" value="' . $buttonText . '">';
    }
?>