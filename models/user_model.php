<?php

require_once "./session_manager.php";
require_once "./validate.php";

class UserModel extends PageModel {
    public $contactmode = "", $email = "", $message= "", $name= "", $password= "", $passwordTwo= "",
     $phonenumber = "", $productId= "", $quantity= "", $salutation = "";

    public $errContactmode = "", $errMail = "", $errMessage = "", $errName = "", $errPassword = ""
    , $errPhonenumber = "", $errProductId = "", $errQuantity = "", $errSalutation = "";

    private $userId = "";
    public $valid = False;

    public function __construct($pageModel) {
        parent::__construct($pageModel);
    }

    public function doLoginUser() {
 
    }

    public function doLogoutUser() {

    }

    private function authenticateUser() {

    }

    public function validateContact() {       
        
        if ($this->isPost) {
            
            //de input vanuit het formulier wordt hier in variabelen gezet en vervolgens opgeschoond door middel van de testInput functie
            $this->salutation = testInput(getPostVar("salutation"));
            $this->name = testInput(getPostVar("name"));
            $this->email = testInput(getPostVar("email"));
            $this->phonenumber = testInput(getPostVar("phonenumber"));
            $this->message = testInput(getPostVar("message"));
			$this->contactmode = testInput(getPostVar("contactmode"));
			
			if (empty($this->salutation)) {				
                $this->errSalutation = "Aanhef moet ingevuld zijn";                
			//Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn                
            } else if (!($this->salutation == "mr." || $this->salutation == "mrs." || $this->salutation == "neither")) {                
                $errSalutation = "Enkel 'Dhr.', 'Mvr.' of 'Geen van beide' zijn valide input";
            }
            
            if (empty($this->name)) {				
                $this->errName = "Naam moet ingevuld zijn";				
			//Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn
			} else if (!preg_match("/^[a-zA-Z-' ]*$/",$this->name)) {
                $this->errName = "Enkel letters en whitespaces zijn toegestaan";
            }       
            
            if (empty($this->email)) {				
                $this->errMail = "Emailadres moet ingevuld zijn";
            //Als email niet leeg is wordt gekeken of er sprake is van een valide emailadres
            } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->errMail = "Vul een valide emailadres in";
            }             
            
            if (empty($this->phonenumber)) {                
				$this->errPhonenumber = "Telefoonnummer moet ingevuld zijn";				
            //Als phonenumber niet leeg is wordt gekeken of phonenumber enkel uit nummers bestaat
            } else if (!is_numeric($this->phonenumber)) {
                $this->errPhonenumber = "Enkel cijfers zijn toegestaan";
            }
            
            if (strlen($this->message) > 100) {
                $this->errMessage = "Het bericht mag maximaal 100 karakters zijn";
            }
            
            //Als contactmode leeg is wordt een foutmelding opgenomen
            if (empty($this->contactmode)) {				
				$this->errContactmode = "U moet een contactwijze kiezen";                
            }
        
            //Als er geen errors voorkomen wordt validInput op true gezet zodat de bedankpagina getoond kan worden
            if (($this->errSalutation == "") && ($this->errName == "") && ($this->errMail == "") && ($this->errPhonenumber == "") && ($this->errContactmode == "") && ($this->errMessage == "")){            
                $this->valid = True;
            } else {
                $this->valid = False;
            }        
        }    
    }

}

?>