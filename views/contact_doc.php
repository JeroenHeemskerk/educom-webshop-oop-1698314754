<?php

require_once "forms_doc.php";

define("SALUTATIONS", array("mr." => "Dhr.", "mrs." => "Mvr.", "neither" => "Geen van beide"));
define("COMM_PREFS", array("email" => "E-mail", "phone" => "Telefoon"));

class ContactDoc extends FormsDoc {
    
    //Overridden method of BasicDoc
    protected function showHeader() {
        echo '<h1>Contact</h1>';
    }

    //Overridden method of BasicDoc
    protected function showContent() {

        if (!$this->model->valid){

        $this->showFormStart();    
        
            //Aanhefkeuze
            echo '<label for="salutation"> Aanhef:</label><br>';
            echo '<select name="salutation" id="salutation">';

            foreach (SALUTATIONS as $value => $label) {
                $this->showFormField("", $label, "select", $this->model, "", $value);
            }

            echo '</select>';
            $this->showErrorSpan($this->model->errSalutation);
            echo '<br><br>';
            
        
            //Formulier met naam, emailadres en telefoonnummer
            $this->showFormField("name", "Naam:", "text", $this->model->name, $this->model->errName, "John Doe");
            $this->showFormField("email", "Emailadres:", "text", $this->model->email, $this->model->errMail, "johndoe@hotmail.com");       
            $this->showFormField("phonenumber", "Telefoonnummer:", "text", $this->model->phonenumber, $this->model->errPhonenumber, "06-12345678");
            
            echo '<br>';
        
            //Radio button met contactwijze
            echo '<label for="contactmode">Contactwijze: </label>';
            $this->showErrorSpan($this->model->errContactmode);
            echo '<br>';

            foreach (COMM_PREFS as $value => $label){
                $this->showFormField("contactmode", $label, "radio", $this->model, "", $value);
            }

            echo '<br>';

            //Tekstbericht
            $this->showFormField("message", "Uw Bericht:", "textarea", $this->model, 'rows="3" cols="50"');
            
            echo '<br><br>';
        
            //Verzendknop
            $this->showFormEnd("contact", "Verzenden");

        } else if ($this->model->valid) {
            //Bedankformulier wordt opgemaakt met de ingevulde gegevens
            echo '<h2>Hartelijk dank voor uw bericht. U zal spoedig een reactie ontvangen.</h2>';
            echo '<h3>Ingevulde gegevens:</h3>';

            echo '<p>Aanhef: ';
            echo $this->model->salutation;

            echo '<br>Naam: ';
            echo $this->model->name; 

            echo '<br>Emailadres: ';
            echo $this->model->email;

            echo '<br>Telefoonnummer: ';
            echo $this->model->phonenumber;

            echo '<br>Contactwijze: '; 
            if ($this->model->contactmode == "email") {                
                echo "email";
            } else {
                echo "telefonisch";
            }

            echo '<br>Bericht: ';
            echo $this->model->message;            
            echo '</p>';   
        }  
    }   
}
?>