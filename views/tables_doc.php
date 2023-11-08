<?php

require_once "product_doc.php";

abstract Class TablesDoc extends ProductDoc {

    protected function dataCell($value = "", $page = "", $id = "", $urlIdSpecification = "", $colspan = 1) {

        echo '<td colspan="' . $colspan . '">';

        if (!empty($page)) {
            echo '<a class="productLink" href="index.php?page=' . $page;
            if (!empty($id)) {
                echo '&' . $urlIdSpecification . '=' . $id;
            }
        echo '"><div class="pagetext">';
        }

        echo $value;

        if (!empty($page)) {
            echo '</div></a>'; 
        }
        echo '</td>';
    }
    
    protected function headerCell($value) {
        echo '<th>' . $value . '</th>';
    }
    
    protected function rowStart() {
        echo '<tr>';
    }
    
    protected function rowEnd() {
        echo '</tr>';
    }
    
    protected function tableStart() {
        echo '<table class="center">';
    }
    
    protected function tableEnd() {
        echo '</table>';
    }
}