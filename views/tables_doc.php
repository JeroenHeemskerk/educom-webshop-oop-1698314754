<?php

require_once "product_doc.php";

abstract Class TablesDoc extends ProductDoc {

    public function dataCell($value = "", $page = "", $id = "", $colspan = 1) {

        switch ($page) {
            case "cart":
                echo '<td colspan="' . $colspan . '"><a class="productLink" href="index.php?page=details&productId=' . $id . '"><div class="pagetext">' . $value . '</div></a></td>';
                break;
            case "orders":
                echo '<td colspan="' . $colspan . '"><a class="productLink" href="index.php?page=orders&orderId=' . $id . '"><div class="pagetext">' . $value . '</div></a></td>';
                break;
            default:
                echo '<td colspan="' . $colspan . '">' . $value . '</td>';
                break;
    
        } 
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