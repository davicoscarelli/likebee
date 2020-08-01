<?php
    class Marker{
    
        private $conn;
        private $table_name = "markers";
    
        public $id;
        public $username;
        public $address;
        public $lat;
        public $lng;
        public $amount;
        
        public function __construct($db){
            $this->conn = $db;
        }

        function read(){
  
            $query = "SELECT * FROM " . $this->table_name . ""
                        
            $stmt = $this->conn->prepare($query);
          
            $stmt->execute();
          
            return $stmt;
        }
        
        function update(){
    
            $query = "UPDATE
                        " . $this->table_name . "
                    SET
                        username = :username,
                        address = :address,
                        lat = :lat,
                        lng = :lng
                        amount = :amount
                    WHERE
                        id = :id";
        
            $stmt = $this->conn->prepare($query);
        
            $this->username=htmlspecialchars(strip_tags($this->username));
            $this->address=htmlspecialchars(strip_tags($this->address));
            $this->lat=htmlspecialchars(strip_tags($this->lat));
            $this->lng=htmlspecialchars(strip_tags($this->lng));
            $this->amount=htmlspecialchars(strip_tags($this->amount));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':lat', $this->lat);
            $stmt->bindParam(':lng', $this->lng);
            $stmt->bindParam(':amount', $this->amount);
            $stmt->bindParam(':id', $this->id);
        
            if($stmt->execute()){
                return true;
            }
        
            return false;
        }
    }
?>