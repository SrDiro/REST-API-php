<?php
class PeopleDB {

    protected $mysqli;
    const LOCALHOST = '127.0.0.1';
    const USER = 'root';
    const PASSWORD = 'root';
    const DATABASE = 'dbTest';

    public function __construct() {
        try{
            $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
        }catch (mysqli_sql_exception $e){
            http_response_code(500);
            exit;
        }
    }

    public function getPeople($id=0){
        $stmt = $this->mysqli->prepare("SELECT * FROM people WHERE id = ? ; ");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $peoples = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $peoples;
    }


    public function getPeoples(){
        $result = $this->mysqli->query('SELECT * FROM people');
        $peoples = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $peoples;
    }


    public function insert($id=0, $name=''){
        $stmt = $this->mysqli->prepare("INSERT INTO people(id, name) VALUES (?, ?); ");
        $stmt->bind_param('ss', $id, $name);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }


    public function delete($id=0) {
        $stmt = $this->mysqli->prepare("DELETE FROM people WHERE id = ? ; ");
        $stmt->bind_param('s', $id);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }


	public function update($id=0, $newName='') {
        if($this->checkID($id)){
            $stmt = $this->mysqli->prepare("UPDATE people SET name=? WHERE id = ? ; ");
            $stmt->bind_param('ss', $newName, $id);
            $r = $stmt->execute();
            $stmt->close();
            return $r;
        }
        return false;
    }


	public function checkID($id){
        $stmt = $this->mysqli->prepare("SELECT * FROM people WHERE ID = ?");
        $stmt->bind_param("s", $id);
        if($stmt->execute()){
            $stmt->store_result();
            if ($stmt->num_rows == 1){
                return true;
            }
        }
        return false;
    }

}
