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
        $this->user = findUserByEmail($this->email);
        if (empty($this->user)) {
            $this->user = NULL;
        }
        if ($this->password != $this->user['password']) {
            $this->user = NULL;
        }
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
            $this->email = testInput(getPostVar("email"));
            $this->password = testInput(getPostVar("password"));
        
            //Vervolgens wordt gekeken of correcte input gegeven is
            $this->errMail = checkEmail($this->email);
            $this->errPassword = checkPassword($this->password);
        
            //Indien geen foutmeldingen gegeven zijn bij het checken van het emailadres en password is sprake van valide input
            if ($this->errMail == "" && $this->errPassword == "") {
                
                try {
                    $this->authenticateUser();
                    
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

    function validateRegister() {

        require_once "./user_service.php";
        require_once "./file_repository.php";

        if ($this->isPost){
        
            //Eerst worden ongewenste karakters verwijderd
            $this->name = testInput(getPostVar("name"));
            $this->email = testInput(getPostVar("email"));
            $this->password = testInput(getPostVar("password"));
            $this->passwordTwo = testInput(getPostVar("passwordTwo"));
        
            //Vervolgens wordt gekeken of correcte input gegeven is
            $this->errName = checkName($this->name);
            $this->errMail = checkEmail($this->email);
			$this->errPassword = checkPassword($this->password);
        
            //Nadat een correct emailadres is opgegeven wordt ook gekeken of er sprake is van een nieuw uniek emailadres
            if ($this->errMail == "") {
                    
                try {
                    $this->errMail = checkNewEmail($this->email);
                } catch (Exception $e) {
                    $this->genericError = "Door een technisch probleem is registreren helaas niet mogelijk op dit moment. Probeer het op een later moment nogmaals.<br>";
                    logError($e->getMessage()); //Schrijf $e naar log functie (deze doet niks op dit moment want is conform opdracht niet geïmplementeerd)
                }
			}				
        
                //Vervolgens wordt bekeken of er wachtwoorden opgegeven zijn, waarna de wachtwoorden met elkaar vergeleken worden
			if ($this->errPassword == ""){
                $this->errPassword = checkRegisterPassword($this->password, $this->passwordTwo);
			}
        
                //Indien sprake is van correcte input wordt een nieuw account aangemaakt en de gebruiker geredirect naar de loginpagina
            if ($this->errName == "" && $this->errMail == "" && $this->errPassword == "") {
                $this->valid = True;        
            }            
        }
    }

}

?>