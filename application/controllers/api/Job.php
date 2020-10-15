<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Job extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->return = array('status' => false, 'message' => 'Something wrong');

		$this->load->model("aj_job_model");
		$this->load->model("aj_user_model");
		$this->load->model("aj_position_model");
		$this->load->helper('api_helper');
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
    		'area' => $this->get('area'),
    		'salary' => $this->get('salary')
    	];

		$list = $this->aj_job_model->get_paginated_filtered_job($perPage, $offset, $getData);
		$jobData = [];
		if ($list) {
			foreach ($list as $jobList) {
				$jobList->company_logo = getPicturePath($jobList->company_logo);
				$jobList->location = $jobList->city_name ?: $jobList->state_name;
				$jobList->creates = timeAgo($jobList->created_at);
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
    	$datas['filter_category'] = array_values(array_unique($filterCategory, SORT_REGULAR));
    	$datas['filter_location'] = array_values(array_unique($filterLocation, SORT_REGULAR));
    	
    	$this->return['status'] = true;
		$this->return['message'] = "Success";
		$this->return['data'] = $datas;

		$this->response($this->return);
	}

	public function jobdetail_get()
	{
		$jobId = $this->get('job_id');
		$userId = $this->get('user_id');
		$data = $this->aj_job_model->getDetailJob($jobId);
		if ($data) {
			$isApplied = $this->aj_job_model->getUserAppliedJob($jobId, $userId);
			$isSaved = $this->aj_job_model->getUserSavedJob($jobId, $userId);
			$data->is_applied = $isApplied ? 1 : 0;
			$data->is_saved = $isSaved ? 1 : 0;
			$data->company_logo = getPicturePath($data->company_logo);
			$data->location = $data->city_name ?: $data->state_name;
			$data->creates = timeAgo($data->created_at);
			unset($data->city_name);
			unset($data->state_name);

			$this->return['status'] = true;
			$this->return['message'] = "Success";
			$this->return['data'] = $data;

		}
		$this->response($this->return);
	}

	public function appliedjob_post()
	{
		$data = [
			'job_id' => $this->post('job_id'),
			'user_id' => $this->post('user_id')
		];

		$datas = $this->aj_user_model->getUserData('cv', $data['user_id']);
		if (!$datas->cv) {
			$this->return['message'] = "Upload cv anda terlebih dahulu";
			return $this->response($this->return);
		}

		$isApplied = $this->aj_job_model->getUserAppliedJob($data['job_id'], $data['user_id']);
		if ($isApplied) {
			$this->return['message'] = "Anda sudah melamar pekerjaan ini";
			return $this->response($this->return);
		}

		$applyJob = $this->aj_job_model->applyJob($data);
		if ($applyJob) {
			$this->return['status'] = true;
			$this->return['message'] = "Success";
		}
		$this->response($this->return);
	}

	public function appliedJob_get()
	{
		$userId = $this->get('user_id');

		$dataJob = $this->aj_job_model->getAppliedJob($userId);
		$datas = [];
		foreach ($dataJob as $value) {
			$data = $this->aj_job_model->getDetailJob($value->job_id);
			$data->company_logo = getPicturePath($data->company_logo);
			$data->location = $data->city_name ?: $data->state_name;
			$data->creates = timeAgo($data->created_at);
			unset($data->city_name);
			unset($data->state_name);

			$datas[] = $data;
		}

		if ($datas) {
			$this->return['status'] = true;
			$this->return['message'] = "Success";
			$this->return['data'] = $datas;
		} else {
			$this->return['message'] = "Empty Result";
		}
		
		$this->response($this->return);
	}

	public function savedjob_post()
	{
		$data = [
			'job_id' => $this->post('job_id'),
			'user_id' => $this->post('user_id')
		];

		$isSaved = $this->aj_job_model->getUserSavedJob($data['job_id'], $data['user_id']);
		if ($isSaved) {
			$this->return['message'] = "Anda sudah menyimpan pekerjaan ini";
			return $this->response($this->return);
		}

		$saveJob = $this->aj_job_model->saveJob($data);
		if ($saveJob) {
			$this->return['status'] = true;
			$this->return['message'] = "Success";
		}
		
		$this->response($this->return);
	}

	public function savedJob_get()
	{
		$userId = $this->get('user_id');

		$dataJob = $this->aj_job_model->getSavedJob($userId);
		$datas = [];
		foreach ($dataJob as $value) {
			$data = $this->aj_job_model->getDetailJob($value->job_id);
			$data->company_logo = getPicturePath($data->company_logo);
			$data->location = $data->city_name ?: $data->state_name;
			$data->creates = timeAgo($data->created_at);
			unset($data->city_name);
			unset($data->state_name);

			$datas[] = $data;
		}

		if ($datas) {
			$this->return['status'] = true;
			$this->return['message'] = "Success";
			$this->return['data'] = $datas;
		} else {
			$this->return['message'] = "Empty Result";
		}
		
		$this->response($this->return);
	}

	public function positionList_get()
	{
		$this->return['status'] = true;
		$this->return['message'] = "Success";
		$this->return['data'] = $this->aj_position_model->get_position_list();

		$this->response($this->return);
	}
}
?>
