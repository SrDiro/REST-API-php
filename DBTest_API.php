<?php
require_once 'PeopleDB.php';
require_once 'ProductsDB.php';

class DBTest_API {


    function deleteRow(){
        if( isset($_GET['action']) && isset($_GET['id']) ){
            if($_GET['action']=='peoples'){
                $db = new PeopleDB();
                $db->delete($_GET['id']);
                $this->response(204);
                exit;
            } else if($_GET['action']=='products'){
                $db = new ProductDB();
                $db->delete($_GET['id']);
                $this->response(204);
                exit;
            }
        }
        $this->response(400);
    }


    function updatePeople() {
		if( isset($_GET['action']) && isset($_GET['id']) ){
			if($_GET['action']=='peoples'){
				$obj = json_decode( file_get_contents('php://input') );
				$objArr = (array)$obj;
				if (empty($objArr)){
					$this->response(422,"error","Nothing to add. Check json");
				}else if(isset($obj->name)){
					$db = new PeopleDB();
					$db->update($_GET['id'], $obj->name);
					$this->response(200,"success","Record updated");
				}else{
					$this->response(422,"error","The property is not defined");
				}
				exit;
			} else if ($_GET['action']=='s'){
				$obj = json_decode( file_get_contents('php://input') );
				$objArr = (array)$obj;
				if (empty($objArr)){
					$this->response(422,"error","Nothing to add. Check json");
				}else if(isset($obj->name)){
					$db = new ProductDB();
					$db->update($_GET['id'], $obj->name);
					$this->response(200,"success","Record updated");
				}else{
					$this->response(422,"error","The property is not defined");
				}
				exit;
		} else {
      $this->response(400);
    }
	}
}

    function saveRow(){
		if($_GET['action']=='peoples'){
			$obj = json_decode( file_get_contents('php://input') );
			$objArr = (array)$obj;
			if (empty($objArr)){
				$this->response(422,"error","Nothing to add. Check json");
			}else if(isset($obj->name)){
				$people = new PeopleDB();
				$people->insert( $obj->name );
				$this->response(200,"success","new record added");
			}else{
				$this->response(422,"error","The property is not defined");
			}
		} else if($_GET['action']=='products'){
			$obj = json_decode( file_get_contents('php://input') );
			$objArr = (array)$obj;
			if (empty($objArr)){
				$this->response(422,"error","Nothing to add. Check json");
			}else if(isset($obj->name)){
				$product = new ProductDB();
				$product->insert( $obj->name );
				$this->response(200,"success","new record added");
			}else{
				$this->response(422,"error","The property is not defined");
			}
		} else {
			$this->response(400);
		}
	}

	function response($code=200, $status="", $message="") {
		http_response_code($code);
		if( !empty($status) && !empty($message) ){
			$response = array("status" => $status ,"message"=>$message);
			echo json_encode($response,JSON_PRETTY_PRINT);
		}
	}

	function getRows(){
		if($_GET['action']=='peoples'){
			$db = new PeopleDB();
			if(isset($_GET['id'])){
				$response = $db->getPeople($_GET['id']);
				echo json_encode($response,JSON_PRETTY_PRINT);
			} else {
				$response = $db->getPeoples();
				echo json_encode($response,JSON_PRETTY_PRINT);
			}
		} else if($_GET['action']=='products'){
			$db = new ProductDB();
			if(isset($_GET['id'])){
				$response = $db->getProduct($_GET['id']);
				echo json_encode($response,JSON_PRETTY_PRINT);
			} else {
				$response = $db->getProducts();
				echo json_encode($response,JSON_PRETTY_PRINT);
			}
		} else {
        $this->response(400);
		}
	}

    public function API(){
        header('Content-Type: application/JSON');
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
        case 'GET':
            $this->getRows();
            break;
        case 'POST':
            $this->saveRow();
            break;
        case 'PUT':
            $this->updateRow();
            break;
        case 'DELETE':
            $this->deleteRow();
            break;
        default:
            $this->response(405);
            break;
        }
    }
}
