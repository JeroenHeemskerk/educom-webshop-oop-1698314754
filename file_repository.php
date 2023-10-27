<?php
    
    function connectToDatabase() {        
        $servername = "localhost";
        $username = "WebShopUser";
        $password = "Testtest!";
        $dbname = "nicks_webshop";
        
        //Create connectie
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        //Check connectie en laat een error zien indien database niet te bereiken is		
		if (!$conn) {
			throw new Exception('Connectie met database is niet tot stand gekomen');
		}
		            
        return $conn;
        
    }
    
    function disconnectFromDatabase($conn) {        
        mysqli_close($conn);
    }
    
    function findUserByEmail($email) {
        
        $conn = connectToDatabase();
        
        $email = mysqli_real_escape_string($conn, $email);
        
        try {
			$sql = "SELECT name, email_address, password FROM users WHERE email_address='" . $email . "'";
			$result = mysqli_query($conn, $sql);            
            
            if ($result == False) {
                throw new Exception('Opgegeven emailadres kon niet worden opgezocht in de database');
            }
            
			$row = mysqli_fetch_assoc($result);                     
            if ($row != Null) {
                return array ('name' => $row["name"], 'email' => $row["email_address"],
                'password' => $row["password"]);
            }
        }
		finally {
            disconnectFromDatabase($conn);
        }
    }
    
    function registerNewAccount($data) {
        
        $conn = connectToDatabase();
        
        $name = mysqli_real_escape_string($conn, $data['name']);
        $email = mysqli_real_escape_string($conn, $data['email']);
        $password = mysqli_real_escape_string($conn, $data['password']);
        
        try{
            $sql = "INSERT INTO users (name, email_address, password)
            VALUES ('" . $name . "', '" . $email . "', '" . $password . "')";

            if (!mysqli_query($conn, $sql)) {
                throw new Exception('Gebruiker kon niet geregistreerd worden in de database');
            }            
        } finally {        
        disconnectFromDatabase($conn);
        }        
    }

    function getAllProducts() {

        $conn = connectToDatabase();

        try {
            $sql = "SELECT * FROM products";
            $result = mysqli_query($conn, $sql);

            if ($result == False) {
                throw new Exception('Producten konden niet uitgelezen worden uit de database');
            }

            $products = array();

            while ($row = mysqli_fetch_assoc($result)) {
                
                $products[$row["product_id"]] = $row;
            }

            return $products;
            
        } finally {
            disconnectFromDatabase($conn);  
        }
    }

    function getUserIdByEmail() {

        $conn = connectToDatabase();

        try {
            $sql = "SELECT user_id FROM users WHERE email_address ='" . $_SESSION['email'] . "'";
            $result = mysqli_query($conn, $sql);         
        
            if ($result == False) {
            throw new Exception('Opgegeven user kon niet worden gevonden in de database op basis van dit emailadres');
            }

            $value = mysqli_fetch_assoc($result);

            return $value["user_id"];
        }
        finally {
            disconnectFromDatabase($conn);
        }
    }

    function getWebshopProduct($productId){

        $conn = connectToDatabase();

        $productId = mysqli_real_escape_string($conn, $productId);

        try{
            $sql = "SELECT * FROM products WHERE product_id='" . $productId . "'";
            $result = mysqli_query($conn, $sql);

            if ($result == False) {
                throw new Exception('Opgegeven product kon niet worden gevonden in de database');
            }
            
            $row = mysqli_fetch_assoc($result);
            return $row;
        } finally {
            disconnectFromDatabase($conn);  
        }
    }

    function getRowsByOrderIdFromDatabase($orderId) {

        $userId = getUserIdByEmail();

        $conn = connectToDatabase();

        try {

            $sql = "SELECT order_row.order_id, order_row.row_id, order_row.product_id,
            order_row.amount, products.name, products.price, products.product_picture_location, price * amount AS total
            FROM order_row
            INNER JOIN products
                ON order_row.product_id=products.product_id
            INNER JOIN orders 
                ON order_row.order_id=orders.order_id
            WHERE (orders.user_id='" . $userId . "' AND order_row.order_id='" . $orderId . "')
            ORDER BY row_id";

            $result = mysqli_query($conn, $sql);

            if ($result == False) {
                throw new Exception('Orders en orderrijen konden niet uitgelezen worden uit de database');
            }

            $result = mysqli_query($conn, $sql);

            $rows = array();

            while ($row = mysqli_fetch_assoc($result)) {
                
                $rows[$row['row_id']] = $row;
            }

            return $rows;

        } finally {
            disconnectFromDatabase($conn); 
        }
    }

    function getOrdersAndSumFromDatabase() {

        $userId = getUserIdByEmail();

        $conn = connectToDatabase();

        try {

            $sql = "SELECT order_row.order_id, SUM(order_row.amount * products.price) AS total
            FROM order_row
            INNER JOIN products
                ON order_row.product_id=products.product_id
            INNER JOIN orders 
                ON order_row.order_id=orders.order_id
            WHERE orders.user_id='" . $userId . "'
            GROUP BY order_row.order_id";

            $result = mysqli_query($conn, $sql);

            if ($result == False) {
                throw new Exception('Orders en totalen konden niet uitgelezen worden uit de database');
            }

            $result = mysqli_query($conn, $sql);

            $orders = array();
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                
                $orders[$row['order_id']] = $row;
                $i++;
            }

            return $orders;

        } finally {
            disconnectFromDatabase($conn); 
        }
    }

    function writeOrderToDatabase($cartLines) {

        //User_id wordt eerste opgezocht nu deze nodig is om een order_id aan te maken
        $userId = getUserIdByEmail();

        $conn = connectToDatabase();

        try {

            //Order_id wordt aangemaakt door middel van de auto increment en het invoegen van een user_id
            $sql = "INSERT INTO orders (user_id)
            VALUES ('" . $userId . "')";
            
            if (mysqli_query($conn, $sql)) {

                //Order_id wordt vervolgens opgehaald
                $orderId = mysqli_insert_id($conn);
            } else {
                throw new Exception('Een nieuwe order kon niet toegevoegd worden aan de database');
            }
            
            foreach ($cartLines as $key => $value){
                $sql = "INSERT INTO order_row (order_id, product_id, amount)
                VALUES ('" . $orderId . "', '" . $key . "', '" . $cartLines[$key]['amount'] . "')";

                if (!mysqli_query($conn, $sql)) {
                    throw new Exception('Orderrij kon niet weggeschreven worden naar de database');
                }
            }
        } finally {
            disconnectFromDatabase($conn);
        }
    }
?>