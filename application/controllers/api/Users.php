<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->return = array('status' => false, 'message' => 'Something wrong');

		$this->load->model("aj_auth_model");
		// $this->load->model("api_user_model");
	}

	public function register_post(){
		$post = [
			'email' => $this->post('email'),
			'password' => $this->post('password'),
			'firstname' => remove_special_characters($this->post('firstname')),
			'lastname' => remove_special_characters($this->post('lastname')),
		];
		print_r($post);
		print_r($_FILES);
		if (!$this->aj_auth_model->is_unique_email($post['email'])) {
			$this->return['message'] = "Email ini sudah di pakai !";
		} else {
			$user = $this->aj_auth_model->register($post);
			if ($user) {
				$this->return['status'] = true;
				$this->return['message'] = "Success";
				$this->return['data'] = $user;
			}
		}

		// $this->response($this->return);
	}
}
?>
