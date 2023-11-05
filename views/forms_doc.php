<?php

require_once "basic_doc.php";

abstract class FormsDoc extends BasicDoc {

    protected function showFormStart() {
        echo '<br><form method="post" action="index.php">';
    }

    protected function showFormEnd($page, $value) {
        //Verborgen variabele om ervoor te zorgen dat de pagina gevonden kan worden middels de getRequestedPage functie van index.php
        echo '<input type="hidden" name="page" value="' . $page . '">';
        echo '<input type="submit" value="' . $value . '">';
        echo '</form>';
    }

    protected function showFormField($fieldName, $label, $inputType, $options = []) {
        $value = $this->model->{$fieldName};
        $error = $this->model->{"err". ucfirst($fieldName)};

        echo '<label for="' . $fieldName . '">' . $label . '</label> ';
        switch ($inputType){
            case("select"):
            echo '<select name="' . $fieldName . '">'; 
            foreach($options as $key => $text) {
                if ($value == $key){ 
                    echo '<option value="' . $key . '" selected>' . $text . '</option>'; 
                } else { 
                    echo '<option value="' . $key. '">' . $text . '</option>'; 
                } 
            }
            echo '</select>';
            $this->showErrorSpan($error); 
            break;
            case ("text"):
                echo '<input type="' . $inputType.'" id="' . $fieldName .  '" name="' . $fieldName . '"'; 
                echo 'value="' . $value . '" placeholder="' . $options . '">'; 
                $this->showErrorSpan($error); 
                break;            
            case ("password"):
                echo '<input type="password" id="' . $fieldName .  '" name="' . $fieldName . '"';
                echo 'value="' . $value . '">';
                $this->showErrorSpan($error);
                break;            
            case ("radio"):
                $this->showErrorSpan($error); 
                foreach($options as $key => $text) {
                    if ($value == $key){ 
                        echo '<input type="radio" checked = "checked" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $key . '">'; 
                        echo '<label for="' . $fieldName . '">' . $text . '</label><br>'; 
                    } else { 
                        echo '<input type="radio" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $key . '">'; 
                        echo '<label for="' . $fieldName . '">' . $text . '</label><br>'; 
                    }
                } 
                break;
            case ("textarea"):
                $this->showErrorSpan($error);
                echo '<textarea id="' . $fieldName . '" name="' . $fieldName . '"' . $options . '">' . $this->model->message . '</textarea>';
            }
    }

    protected function showErrorSpan($error) {
        echo '<span> ' . $error . '</span>';
        echo '<br>';
    }
}
?>