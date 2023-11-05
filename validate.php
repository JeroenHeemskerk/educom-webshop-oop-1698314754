<?php
class Validate extends PageModel{
    protected function checkEmail($email) {
		
        if (empty($email)) {			
            return "Emailadres moet ingevuld zijn";  
			
        //Als email niet leeg is wordt gekeken of er sprake is van een valide emailadres
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "Vul een valide emailadres in";
        } 
		
		return "";
    }
    
    protected function checkNewEmail($email) {
		
        //doesEmailExist staat in user_service.php
        if (doesEmailExist($email)) {
            return "Dit emailadres is al in gebruik";
        }
        return "";
    }

    protected function checkName($name) {    
		
		if (empty($name)) {
			return "Naam moet ingevuld zijn";

		//Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn
		} else if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
			return "Enkel letters en whitespaces zijn toegestaan";
		} else {
			return "";
		}
    }
    
    protected function checkPassword($password) {   
	
        if ($password == ""){
            return "Er is geen wachtwoord opgegeven";
        }
    }

    protected function checkProductId($productId){

        if ($productId <= 0 || $productId >= 9999999999 || !is_numeric($productId)) {
            return "Het toe te voegen product bestaat niet";
        }
    }

    protected function checkQuantity($quantity) {

        if (!is_numeric($quantity)) {
            return "Er moet bij 'Aantal' een getal opgegeven worden";
        } else if ($quantity <= 0) {
            return "De hoeveelheid aan te schaffen producten moet hoger dan 0 zijn";
        } else if ($quantity > 100) {
            return "Er kan niet meer dan 100 van hetzelfde product tegelijkertijd aangeschaft worden";
        }
    }
    
    protected function checkRegisterPassword($password, $passwordTwo) {
		
		if (empty($passwordTwo)) {
			return "Het wachtwoord moet ter controle nog een keer ingevuld worden";
			
		//Als password niet leeg is wordt gekeken of er sprake is van een tweede wachtwoord welke gelijk moet zijn aan de eerste
		} else if ($password == $passwordTwo) {
			return "";
		} else {
			return "De wachtwoorden moeten gelijk zijn aan elkaar";
		}
			
    }
    
    protected function testInput($input) {
        
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

}
?>