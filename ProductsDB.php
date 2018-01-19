<?php
class ProductDB {

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

    public function getProduct($id=0){
        $stmt = $this->mysqli->prepare("SELECT * FROM products WHERE cod_product = ? ; ");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $products;
    }


    public function getProducts(){
        $result = $this->mysqli->query('SELECT * FROM products');
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        return $products;
    }


    public function insert($name=''){
        $stmt = $this->mysqli->prepare("INSERT INTO products(name) VALUES (?); ");
        $stmt->bind_param('s', $name);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }


    public function delete($id=0) {
        $stmt = $this->mysqli->prepare("DELETE FROM products WHERE cod_product = ? ; ");
        $stmt->bind_param('s', $id);
        $r = $stmt->execute();
        $stmt->close();
        return $r;
    }


	public function update($id, $newName) {
        if($this->checkID($id)){
            $stmt = $this->mysqli->prepare("UPDATE products SET name=? WHERE cod_product = ? ; ");
            $stmt->bind_param('ss', $newName,$id);
            $r = $stmt->execute();
            $stmt->close();
            return $r;
        }
        return false;
    }


	public function checkID($id){
        $stmt = $this->mysqli->prepare("SELECT * FROM products WHERE cod_product = ?");
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
