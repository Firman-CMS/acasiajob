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
}
?>
