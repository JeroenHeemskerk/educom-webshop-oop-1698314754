<?php   
    include "db_repository.php";

    //getOrdersFromDatabase();
    $CRUD = new CRUD();

    
    $sql = "INSERT INTO users (name, email_address, password)
    VALUES (:name, :email, :password)";
    $values = array("name" => "Joost", "email" => "Joost@t.t", "password" =>"s");
    $result = $CRUD->createRow($sql, $values);
    print_r($result);
    
    /*
    $sql = "SELECT * FROM order_row WHERE (order_id = :orderId)";
    $value = array("orderId" => 40);
    $result = $CRUD->readOneRow($sql, $value);
    print_r($result);
    */
    /*
    $sql = "DELETE FROM users WHERE (user_id = :userId)";
    $value = array("userId" => 25);
    $CRUD->deleteRow($sql, $value);
    */

    /*
    $sql = "SELECT order_row.order_id, order_row.row_id, order_row.product_id,
            order_row.amount, products.price, price * amount AS total
            FROM order_row
            INNER JOIN products
                ON order_row.product_id=products.product_id
            INNER JOIN orders 
                ON order_row.order_id=orders.order_id
            WHERE (orders.user_id = :userId) AND (order_row.order_id = :orderId)
            ORDER BY row_id";
    $value = array("userId" => 1,"orderId" => 46);
    $result = $CRUD->readMultipleRows($sql, $value);
    print_r($result);
    */
    
    /*
    $sql = "UPDATE users SET email_address = :email WHERE user_id = :userId";
    $value = array("email" => "sjakie@sjakie.sjakie", "userId" => "22");
    $CRUD->updateRow($sql, $value);
    */
    
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

    function getUserIdByEmail() {

        return 1;
    }

    function getOrdersFromDatabase() {

        $userId = getUserIdByEmail();

        $conn = connectToDatabase();

        $orderId = 2;

        
        $sql = "SELECT order_row.order_id, order_row.row_id, order_row.product_id,
            order_row.amount, products.price, price * amount AS total
            FROM order_row
            INNER JOIN products
                ON order_row.product_id=products.product_id
            INNER JOIN orders 
                ON order_row.order_id=orders.order_id
            WHERE (orders.user_id='" . $userId . "' AND order_row.order_id='" . $orderId . "')
            ORDER BY row_id"; //Hier kan denk ik nog WHERE order_id op klik op pagina
        

        /*
        $sql = "SELECT order_row.order_id, SUM(order_row.amount * products.price)
        FROM order_row
        INNER JOIN products
            ON order_row.product_id=products.product_id
        INNER JOIN orders 
            ON order_row.order_id=orders.order_id
        WHERE orders.user_id='" . $userId . "'
        GROUP BY order_row.order_id";
        */

        $result = mysqli_query($conn, $sql);

        $orders = array();

        while ($row = mysqli_fetch_assoc($result)) {
                
            $orders[$row['row_id']] = $row; //is row_id voor de andere
        }

            print_r($orders);
        
        disconnectFromDatabase($conn);
        }


/*
//Nieuw record klaar zetten
$sql = "INSERT INTO users (name, email_address, password)
VALUES ('Bob', 'bob@hotmail.com', 'bob')";

//Nieuw record toevoegen
if (mysqli_query($conn, $sql)) {
    echo 'New record created successfully';
} else {
    echo 'Error: ' . $sql . '<br>' . mysqli_error($conn);
}*/

/*
$sql = "SELECT user_id, name, email_address, password FROM users";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    //output data van elke rij
    while ($row = mysqli_fetch_assoc($result)) {
        echo 'user_id: ' . $row["user_id"] . ' - Name: ' . $row["name"] . ' - Emailadres: ' .
        $row["email_address"] . ' - Wachtwoord: ' . $row["password"] . '<br>';
    }
} else {
    echo "Geen resultaten";
}*/

/*
$email = "bob@hotmail.com";

try {
        $sql = "SELECT name, email_address, password FROM users WHERE email_address='" . $email . "'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);            
        if ($row != False) {
                $data = array('name' => $row["name"], 'email' => $row["email_address"],
                'password' => $row["password"]);
                print_r($data);
            }
}
finally {
    mysqli_close($conn);
}*/

//user_id name email_address password

?>