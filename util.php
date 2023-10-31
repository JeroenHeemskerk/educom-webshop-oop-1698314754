<?php
public static class Util {
    
    function getPostVar($key, $default=''){
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }
	
	function getUrlVar($key, $default='') { 
		return isset($_GET[$key]) ? $_GET[$key] : $default; 
	} 
}
?>