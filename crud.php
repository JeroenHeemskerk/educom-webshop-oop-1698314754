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

        public function createRow($sql, $values, $multipleRows = False){
            try {     
                $stmt = $this->pdo->prepare($sql);

                if ($multipleRows)  {
                    //Bind wordt meerdere keren aangeroepen indien meerdere rijen naar de database geschreven moeten worden
                    foreach ($values as $key => $valuesToBeBound) {
                        $stmt = $this->bind($stmt, $valuesToBeBound);                
                        $stmt->execute();
                    }
                } else {
                    $stmt = $this->bind($stmt, $values);                
                    $stmt->execute();
                    $result = $this->pdo->lastInsertId();
                    return $result;
                }
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

        public function readMultipleRows($sql, $values = [], $multipleSearches = False) {
            try {
                $stmt = $this->pdo->prepare($sql);

                //Indien $values leeg is wordt een gehele tabel opgehaald
                if (!empty($values) && $multipleSearches) {

                    $stmt->setFetchMode(PDO::FETCH_OBJ);

                    $i = 0;
                    foreach($values as $key => $value){
                        $stmt = $this->bind($stmt, $value);
                        $stmt->execute();
                        $row = $stmt->fetch();
                        $result[$i] = $row;
                        $i++;
                    }
                
                    return $result;

                } else if (!empty($values) && !$multipleSearches) {
                    $stmt = $this->bind($stmt, $values);
                }

                $stmt->setFetchMode(PDO::FETCH_OBJ);

                $stmt->execute();

                $i = 0;
                while ($row = $stmt->fetch()) {
                    $result[$i] = $row;
                    $i++;
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