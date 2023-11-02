<?php

require_once "./validate.php";
require_once "./session_manager.php";

class UserModel extends PageModel {
    public $contactmode = "", $email = "", $message= "", $name= "", $password= "", $passwordTwo= "",
     $phonenumber = "", $productId= "", $quantity= "", $salutation = "";

    public $errContactmode = "", $errMail = "", $errMessage = "", $errName = "", $errPassword = ""
    , $errPhonenumber = "", $errProductId = "", $errQuantity = "", $errSalutation = "";

    private $user = array();
    public $valid = False;

    public function __construct($pageModel) {
        parent::__construct($pageModel);
    }

    public function doLoginUser($name, $email) {
        $this->sessionManager->loginUser($name, $email);
    }

    public function doLogoutUser() {
        $this->sessionManager->logoutUser();
    }

    public function doGetLoggedInUsername() {
        $this->sessionManager->getLoggedInUsername();
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

    public function validateLogin() {

        require_once "./user_service.php";
        require_once "./file_repository.php";
    
        if ($this->isPost){
        
            //Eerst worden ongewenste karakters verwijderd
            $this->email = testInput($_POST["email"]);
            $this->password = testInput($_POST["password"]);
        
            //Vervolgens wordt gekeken of correcte input gegeven is
            $this->errMail = checkEmail($this->email);
            $this->errPassword = checkPassword($this->password);
        
            //Indien geen foutmeldingen gegeven zijn bij het checken van het emailadres en password is sprake van valide input
            if ($this->errMail == "" && $this->errPassword == "") {
                
                try {
                    $this->user = authenticateUser($this->email, $this->password);
                    
                    if (!empty($this->user)) {
                        $this->name = $this->user['name'];
                        $this->valid = True;
                    } else {
                        $this->errMail = "Opgegeven emailadres is niet gekoppeld aan een gebruiker of incorrect wachtwoord";
                    }                
                }
                catch (Exception $e) {
                    $this->genericError = "Door een technisch probleem is inloggen helaas niet mogelijk op dit moment. Probeer het op een later moment nogmaals<br>";
                    logError($e->getMessage()); //Schrijf $e naar log functie
                }
            }
        }
    }

}

?>