<?php
    class Crud {
        private $username = "WebShopUser";
        private $password = "Testtest!";
        private $connectionString = "mysql:host=localhost;dbname=nicks_webshop";
        private PDO $pdo;

        public function __construct() {
            $this->pdo = new PDO($this->connectionString, $this->username, $this->password);
        }

        private function bind($stmt, $values) {
            //Bind zet de waarde correct neer op basis van de key
            foreach($values as $key => $value) {                           
                $stmt->bindValue($key, $value);
            }
            return $stmt;
        }

        public function createRow($sql, $values){
            try {     
                $stmt = $this->pdo->prepare($sql);
                $stmt = $this->bind($stmt, $values);                
                $stmt->execute();

                $result = $this->pdo->lastInsertId();
                return $result;
            } catch (PDOException $e) {
                echo 'Error' . $e->getMessage();
            }
        }

        public function deleteRow($sql, $values) {
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt = $this->bind($stmt, $values);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Error' . $e->getMessage();
            }
        }

        public function readOneRow($sql, $values) {            
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt = $this->bind($stmt, $values);

                $stmt->setFetchMode(PDO::FETCH_OBJ);

                $stmt->execute();

                $result = $stmt->fetch();

                return $result;
            } catch (PDOException $e) {
                echo 'Error' . $e->getMessage();
            }
        }

        public function readMultipleRows($sql, $values) {
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt = $this->bind($stmt, $values);

                $stmt->setFetchMode(PDO::FETCH_OBJ);

                $stmt->execute();

                while ($row = $stmt->fetch()) {
                    $result[$row->row_id] = $row;
                }

                return $result;
            } catch (PDOException $e) {
                echo 'Error' . $e->getMessage();
            }
        }

        public function updateRow($sql, $values) {
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt = $this->bind($stmt, $values);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Error' . $e->getMessage();
            }
        }
}
?>