<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Categories extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->return = array('status' => false, 'message' => 'Something wrong');

		$this->load->model("aj_category_model");
	}

	public function listcategory_get(){

		$data = $this->aj_category_model->get_category_list();
		
		if (!$data[0]['value']) {
			return $this->response($this->return);
		}

		$list[] = ['label'=> 'All', 'value' => 'all'];
		foreach ($data as $value) {
			array_push($list, $value);
		}

		$this->return['status'] = true;
		$this->return['message'] = "Success";
		$this->return['data'] = $list;

		$this->response($this->return);
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
			$dataUser = $user ?: "";

			$this->return['status'] = true;
			$this->return['message'] = "Success";
			$this->return['data'] = $dataUser;
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
