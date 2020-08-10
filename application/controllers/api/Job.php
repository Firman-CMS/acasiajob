<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Job extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->return = array('status' => false, 'message' => 'Something wrong');

		$this->load->model("aj_job_model");
		$this->job_per_page = 8;
	}

	public function jobvacancy_get(){

		$page = $this->get('page') ?: '1';
    	$perPage = $this->get('per_page') ?: $this->job_per_page;
    	$offset = $perPage * ($page - 1);

    	$getData = [
    		'search' => $this->get('search'),
    		'category' => $this->get('category'),
    		'location' => $this->get('location'),
    		'area' => $this->get('area')
    	];

		$list = $this->aj_job_model->get_paginated_filtered_job($perPage, $offset, $getData);
		$jobData = [];
		if ($list) {
			foreach ($list as $jobList) {
				$jobList->company_logo = getPicturePath($jobList->company_logo);
				$jobList->location = $jobList->city_name ?: $jobList->state_name;
				unset($jobList->city_name);
				unset($jobList->state_name);
				$jobData[] = $jobList;
			}
		}

		$this->return['status'] = true;
		$this->return['message'] = "Success";
		$this->return['data'] = $jobData;

		$this->response($this->return);
	}

	public function jobfilter_get()
	{
		$getData = [
    		'area' => $this->get('area')
    	];

    	$list = $this->aj_job_model->get_filter_job($getData);

    	$filterCategory = [];
    	$filterLocation = [];
    	foreach ($list as $data) {
    		$filterCategory[] = [
    			'label' => $data->category_name,
    			'value' => $data->category_id,
    		];

    		$labelLocation = $data->city_id ? $data->city_name : $data->state_name;
    		$valueLocation = $data->city_id ? $data->city_id : 'p'.$data->state_id;
    		$filterLocation[] = [
    			'label' => $labelLocation,
    			'value' => $valueLocation,
    		];
    	}

    	$datas['filter_category'] = array_unique($filterCategory, SORT_REGULAR);
    	$datas['filter_location'] = array_unique($filterLocation, SORT_REGULAR);

    	$this->return['status'] = true;
		$this->return['message'] = "Success";
		$this->return['data'] = $datas;

		$this->response($this->return);
	}
}
?>
