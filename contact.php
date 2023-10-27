<?php

    define("SALUTATIONS", array("mr." => "Dhr.", "mrs." => "Mvr.", "neither" => "Geen van beide"));
    define("COMM_PREFS", array("email" => "E-mail", "phone" => "Telefoon"));
    
	function getContactHeader($data) {
        if (!$data['valid']) {
            return "Contact";
        } else if ($data['valid']) {
            return "Dankuwel";
        }
    }
    
    function showContactBody($data) {
        
        if (!$data['valid']){
        
            showFormStart();    
        
            //Aanhefkeuze
            echo '<label for="salutation"> Aanhef:</label><br>';
            echo '<select name="salutation" id="salutation">';

            foreach (SALUTATIONS as $value => $label) {
                showFormField("", $label, "select", $data, "", $value);
            }

            echo '</select>';
            showErrorSpan($data['errSalutation']);
            echo '<br><br>';
            
        
            //Formulier met naam, emailadres en telefoonnummer
            showFormField("name", "Naam:", "text", $data['name'], $data['errName'], "John Doe");
            showFormField("email", "Emailadres:", "text", $data['email'], $data['errMail'], "johndoe@hotmail.com");       
            showFormField("phonenumber", "Telefoonnummer:", "text", $data['phonenumber'], $data['errPhonenumber'], "06-12345678");
            
            echo '<br>';
        
            //Radio button met contactwijze
            echo '<label for="contactmode">Contactwijze: </label>';
            showErrorSpan($data['errContactmode']);
            echo '<br>';

            foreach (COMM_PREFS as $value => $label){
                showFormField("contactmode", $label, "radio", $data, "", $value);
            }

            echo '<br>';

            //Tekstbericht
            showFormField("message", "Uw Bericht:", "textarea", $data, 'rows="3" cols="50"');
            
            echo '<br><br>';
        
            //Verzendknop
            showFormEnd("contact", "Verzenden");

        } else if ($data['valid']) {
            //Bedankformulier wordt opgemaakt met de ingevulde gegevens
            echo '<h2>Hartelijk dank voor uw bericht. U zal spoedig een reactie ontvangen.</h2>';
            echo '<h3>Ingevulde gegevens:</h3>';

            echo '<p>Aanhef: ';
            echo $data['salutation'];

            echo '<br>Naam: ';
            echo $data['name']; 

            echo '<br>Emailadres: ';
            echo $data['email'];

            echo '<br>Telefoonnummer: ';
            echo $data['phonenumber'];

            echo '<br>Contactwijze: '; 
            if ($data['contactmode'] == "email") {
                
                echo "email";
            } else {
                echo "telefonisch";
            }

            echo '<br>Bericht: ';
            echo $data['message'];            
            echo '</p>';   
        }  
    }        
?>