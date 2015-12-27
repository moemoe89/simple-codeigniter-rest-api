<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
				$params = json_decode(file_get_contents('php://input'), TRUE);
		        $username = $params['username'];
		        $password = $params['password'];
		        
		        $response = $this->MyModel->login($username,$password);
				$this->json_output($response['status'],$response);
			} else {
				$this->json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
			}
		}
	}

	public function logout()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			$this->json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->MyModel->check_auth_client();
			if($check_auth_client == true){
		        $response = $this->MyModel->logout();
				$this->json_output($response['status'],$response);
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
