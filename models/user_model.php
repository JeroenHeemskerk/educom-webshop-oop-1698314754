<?php
require_once "./util.php";
require_once "./validate.php";
require_once "./session_manager.php";

class UserModel extends Validate {
    public $contactmode, $email, $message, $name, $password, $passwordTwo,
    $phonenumber, $productId, $salutation;

    public $errContactmode = "", $errEmail = "", $errMessage = "", $errName = "", $errPassword = "", 
    $errPasswordTwo = "", $errPhonenumber = "", $errProductId = "", $errSalutation = "";

    private $user;

    private UserCrud $userCrud;

    public function __construct($pageModel, $userCrud) {
        parent::__construct($pageModel);
        $this->userCrud = $userCrud;
    }

    public function doLoginUser() {
        $this->sessionManager->loginUser($this->userId, $this->name, $this->email);
    }

    public function doLogoutUser() {
        $this->sessionManager->logoutUser();
    }

    public function doGetLoggedInUsername() {
        $this->sessionManager->getLoggedInUsername();
    }

    public function doRegisterNewAccount() {
        $this->userCrud->createUser($this->name, $this->email, $this->password);
    }

    public function authenticateUser() {
        $this->user = $this->userCrud->readUserByEmail($this->email);

        //Indien user niet gevonden is geeft de functie null terug
        if (empty($this->user)) {
            $this->user = NULL;
        } else {
            //Indien een user is gevonden op basis van het opgegeven emailadres wordt het wachtwoord nagekeken
            if ($this->password != $this->user->password) {
                $this->user = NULL;
            }
        }
    }

    private function checkNewEmail($email) {
        if (!empty($this->userCrud->readUserByEmail($email))) {
            return "Dit emailadres is al in gebruik";
        }
        return "";
    }

    public function validateContact() {       
        
        if ($this->isPost) {
            
            //De input vanuit het formulier wordt hier in variabelen gezet en vervolgens opgeschoond door middel van de testInput functie
            $this->salutation = $this->testInput(Util::getPostVar("salutation"));
            $this->name = $this->testInput(Util::getPostVar("name"));
            $this->email = $this->testInput(Util::getPostVar("email"));
            $this->phonenumber = $this->testInput(Util::getPostVar("phonenumber"));
            $this->message = $this->testInput(Util::getPostVar("message"));
			$this->contactmode = $this->testInput(Util::getPostVar("contactmode"));
			
			if (empty($this->salutation)) {				
                $this->errSalutation = "Aanhef moet ingevuld zijn";                
			//Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn                
            } else if (!($this->salutation == "mr." || $this->salutation == "mrs." || $this->salutation == "neither")) {                
                $this->errSalutation = "Enkel 'Dhr.', 'Mvr.' of 'Geen van beide' zijn valide input";
            }
            
            if (empty($this->name)) {				
                $this->errName = "Naam moet ingevuld zijn";				
			//Als name niet leeg is wordt gekeken of er enkel letters en whitespaces ingevuld zijn
			} else if (!preg_match("/^[a-zA-Z-' ]*$/",$this->name)) {
                $this->errName = "Enkel letters en whitespaces zijn toegestaan";
            }       
            
            if (empty($this->email)) {				
                $this->errEmail = "Emailadres moet ingevuld zijn";
            //Als email niet leeg is wordt gekeken of er sprake is van een valide emailadres
            } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->errEmail = "Vul een valide emailadres in";
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
            if (($this->errSalutation == "") && ($this->errName == "") && ($this->errEmail == "") && ($this->errPhonenumber == "") && ($this->errContactmode == "") && ($this->errMessage == "")){            
                $this->valid = True;
            } else {
                $this->valid = False;
            }        
        }    
    }

    public function validateLogin() {
    
        if ($this->isPost){
        
            //Eerst worden ongewenste karakters verwijderd
            $this->email = $this->testInput(Util::getPostVar("email"));
            $this->password = $this->testInput(Util::getPostVar("password"));
        
            //Vervolgens wordt gekeken of correcte input gegeven is
            $this->errEmail = $this->checkEmail($this->email);
            $this->errPassword = $this->checkPassword($this->password);
        
            //Indien geen foutmeldingen gegeven zijn bij het checken van het emailadres en password is sprake van valide input
            if ($this->errEmail == "" && $this->errPassword == "") {
                
                try {
                    $this->authenticateUser();
                    
                    if (!empty($this->user)) {
                        $this->name = $this->user->name;
                        $this->userId = $this->user->user_id;
                        $this->valid = True;
                    } else {
                        $this->errEmail = "Opgegeven emailadres is niet gekoppeld aan een gebruiker of incorrect wachtwoord";
                    }                
                }
                catch (Exception $e) {
                    $this->genericError = "Door een technisch probleem is inloggen helaas niet mogelijk op dit moment. Probeer het op een later moment nogmaals<br>";
                    logError($e->getMessage()); //Schrijf $e naar log functie
                }
            }
        }
    }

    public function validateRegister() {

        if ($this->isPost){
        
            //Eerst worden ongewenste karakters verwijderd
            $this->name = $this->testInput(Util::getPostVar("name"));
            $this->email = $this->testInput(Util::getPostVar("email"));
            $this->password = $this->testInput(Util::getPostVar("password"));
            $this->passwordTwo = $this->testInput(Util::getPostVar("passwordTwo"));
        
            //Vervolgens wordt gekeken of correcte input gegeven is
            $this->errName = $this->checkName($this->name);
            $this->errEmail = $this->checkEmail($this->email);
			$this->errPassword = $this->checkPassword($this->password);
        
            //Nadat een correct emailadres is opgegeven wordt ook gekeken of er sprake is van een nieuw uniek emailadres
            if ($this->errEmail == "") {
                    
                try {
                    $this->errEmail = $this->checkNewEmail($this->email);
                } catch (Exception $e) {
                    $this->genericError = "Door een technisch probleem is registreren helaas niet mogelijk op dit moment. Probeer het op een later moment nogmaals.<br>";
                    logError($e->getMessage()); //Schrijf $e naar log functie (deze doet niks op dit moment want is conform opdracht niet geïmplementeerd)
                }
			}				
        
                //Vervolgens wordt bekeken of er wachtwoorden opgegeven zijn, waarna de wachtwoorden met elkaar vergeleken worden
			if ($this->errPassword == ""){
                $this->errPassword = $this->checkRegisterPassword($this->password, $this->passwordTwo);
			}
        
                //Indien sprake is van correcte input wordt een nieuw account aangemaakt en de gebruiker geredirect naar de loginpagina
            if ($this->errName == "" && $this->errEmail == "" && $this->errPassword == "") {
                $this->valid = True;        
            }            
        }
    }

}

?>