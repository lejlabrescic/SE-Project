<?php
require_once __DIR__."/../Config.class.php";
class BaseDao
{
    private $conn;

    private $table_name;

    public function __construct($table_name)
    {
        try {
            $this->table_name = $table_name;
            $servername = "localhost";
            $username = "root";
            $password = "";
            $port = 3306;
            $schema = "sneakershop";
            $this->conn = new PDO("mysql:host=$servername;port = $port;dbname=$schema", $username, $password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    
    public function get_all()
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_by_id($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE id=:id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }


    public function add($entity){
        $query = "INSERT INTO " . $this->table_name . " (";
        foreach($entity as $column => $value){
            $query.= $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query.= ") VALUES (";
        foreach($entity as $column => $value){
            $query.= ":" . $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query.= ")";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($entity);
        $entity['id'] = $this->conn->lastInsertId();
        return $entity;
    }



    public function update($entity, $id, $id_column = "id"){
        $query = "UPDATE " . $this->table_name . " SET ";
        foreach($entity as $column => $value){
            $query.= $column . "=:" . $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query.= " WHERE ${id_column} = :id";
        $stmt = $this->conn->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);
        return $entity;
    }



    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id = :id");
        $stmt->bindParam(':id', $id); #prevent SQL injection
        $stmt->execute();
    }


}
?>