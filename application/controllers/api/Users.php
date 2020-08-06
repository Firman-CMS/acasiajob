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

		$this->response($this->return);
	}

	public function login_post(){
		$post = [
			'email' => $this->post('email'),
			'password' => $this->post('password'),
			'device_id' => $this->post('device_id')
		];
		try {
			$checkLogin = $this->aj_auth_model->login($post);

			if ($checkLogin) {
				$data = $this->aj_auth_model->get_user_by_email($post['email']);
				$this->return['status'] = true;
				$this->return['message'] = 'success';
				$this->return['data'] = $data;
			}else{
				$this->return['message'] = 'Email atau password salah!';
			}
		} catch (Exception $e) {
			$this->return['message'] = $e->getMessage();
		}

		$this->response($this->return);
	}
}
?>
