<?php

require_once "product_doc.php";

abstract Class TablesDoc extends ProductDoc {

    public function dataCell($value = "", $page = "", $id = "", $colspan = 1) {

        echo '<td colspan="' . $colspan . '">';

        if (!empty($page)) {
            echo '<a class="productLink" href="index.php?page=' . $page;
            if (!empty($id)) {
                echo '&id=' . $id;
            }
        echo '"><div class="pagetext">';
        }

        echo $value;

        if (!empty($page)) {
            echo '</div></a>'; 
        }
        echo '</td>';
    }
    
    public function headerCell($value) {
        echo '<th>' . $value . '</th>';
    }
    
    public function rowStart() {
        echo '<tr>';
    }
    
    public function rowEnd() {
        echo '</tr>';
    }
    
    public function tableStart() {
        echo '<table class="center">';
    }
    
    public function tableEnd() {
        echo '</table>';
    }
}