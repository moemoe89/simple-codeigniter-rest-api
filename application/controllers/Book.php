<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller {

	public function index()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->auth();
		        if($response['status'] == 200){
		        	$resp = $this->MyModel->book_all_data();
		        } else {
		        	$resp = $response;
		        } 
	    		$this->json_output($response['status'],$resp);
			} else {
				$this->json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
			}
		}
	}

	public function detail($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET' || $this->uri->segment(3) == ''){
			$this->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->auth();
		        if($response['status'] == 200){
		        	$resp = $this->MyModel->book_detail_data($id);
		        } else {
		        	$resp = $response;
		        }
				$this->json_output($response['status'],$resp);
			} else {
				$this->json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
			}
		}
	}

	public function create()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->auth();
		        $respStatus = $response['status'];
		        if($response['status'] == 200){
					$params = json_decode(file_get_contents('php://input'), TRUE);
					if ($params['title'] == "" || $params['author'] == "") {
						$respStatus = 400;
						$resp = array('status' => 400,'message' =>  'Title & Author can\'t empty');
					} else {
		        		$resp = $this->MyModel->book_create_data($params);
					}
		        } else {
		        	$resp = $response;
		        }
				$this->json_output($respStatus,$resp);
			} else {
				$this->json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
			}
		}
	}

	public function update($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'PUT' || $this->uri->segment(3) == ''){
			$this->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->auth();
		        $respStatus = $response['status'];
		        if($response['status'] == 200){
					$params = json_decode(file_get_contents('php://input'), TRUE);
					$params['updated_at'] = date('Y-m-d H:i:s');
					if ($params['title'] == "" || $params['author'] == "") {
						$respStatus = 400;
						$resp = array('status' => 400,'message' =>  'Title & Author can\'t empty');
					} else {
		        		$resp = $this->MyModel->book_update_data($id,$params);
					}
		        } else {
		        	$resp = $response;
		        }
				$this->json_output($respStatus,$resp);
			} else {
				$this->json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
			}
		}
	}

	public function delete($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'DELETE' || $this->uri->segment(3) == ''){
			$this->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->auth();
		        if($response['status'] == 200){
		        	$resp = $this->MyModel->book_delete_data($id);
		        } else {
		        	$resp = $response;
		        }
				$this->json_output($response['status'],$resp);
			} else {
				$this->json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
			}
		}
	}

	public function json_output($statusHeader,$response)
	{
		$this->output->set_status_header($statusHeader);
		$this->output
			 	->set_content_type('application/json')
				->set_output(json_encode($response));
	}

}
