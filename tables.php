<?php

function dataCell($value = "", $page = "", $id = "", $colspan = 1) {

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

function headerCell($value) {
    echo '<th>' . $value . '</th>';
}

function rowStart() {
    echo '<tr>';
}

function rowEnd() {
    echo '</tr>';
}

function tableStart() {
    echo '<table class="center">';
}

function tableEnd() {
    echo '</table>';
}
?>