<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_job_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model("aj_notifikasi_model");
        $this->load->model("aj_category_model");
        $this->load->model("aj_position_model");
        $this->load->model("aj_job_model");
        $this->load->model("upload_model");
        $this->load->model("location_model");
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }

    public function job_vacancy()
    {
    	$data['title'] = trans("job_vacancy");
        $data['position'] = $this->aj_position_model->get_position_list();
        $data['category'] = $this->aj_category_model->get_category_list();
        $data['company'] = $this->aj_job_model->get_company_list();
        $data['country'] = $this->aj_job_model->get_country_list();
        $data['state'] = $this->aj_job_model->get_state_list(102);
        // print_r($data);
        // die;
        $data['lang_search_column'] = 2;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/job/add_new', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function add_new_post()
    {
        if ($this->aj_job_model->add_new()) {
            $this->session->set_flashdata('success_form', trans("msg_category_added"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error_form', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    public function list_job()
    {
        $data['title'] = trans("list_job_vacancy");
        $data['form_action'] = admin_url() . "list-job-vacancy";
        $pagination = $this->paginate(admin_url() . 'list-job-vacancy', $this->aj_job_model->get_paginated_job_count());
        $data['job'] = $this->aj_job_model->get_all_job($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/job/list', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function detail_job($id)
    {
    	$data['title'] = trans("detail_job");
    	$job = $this->aj_job_model->get_by_id($id);
        if (empty($job)) {
            redirect($this->agent->referrer());
        }

        $dataState = '';
        if ($job->country_id) {
        	$dataState = $this->aj_job_model->get_state_list($job->country_id);
        }

        $dataCity = '';
        if ($job->state_id) {
        	$dataCity = $this->aj_job_model->get_cities_list($job->state_id);
        }

    	$data['job'] = $job;
    	$data['position'] = $this->aj_position_model->get_position_list();
        $data['category'] = $this->aj_category_model->get_category_list();
        $data['company'] = $this->aj_job_model->get_company_list();
        $data['country'] = $this->aj_job_model->get_country_list();
        $data['state'] = $dataState;
        $data['city'] = $dataCity;


        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/job/edit', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function edit_post()
    {
        if ($this->aj_job_model->edit_post()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
                redirect(admin_url() . 'list-job-vacancy');
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    public function delete_item()
    {
    	$id = $this->input->post('id', true);
        $this->aj_job_model->delete_selected_id($id);
    }

    //get state
    public function get_state()
    {
        $country_id = $this->input->post('country_id', true);
        $states = $this->location_model->get_states_by_country($country_id);
        foreach ($states as $item) {
            echo '<option value="' . $item->id . '">' . $item->name . '</option>';
        }

    }
    
    //get cities
    public function get_cities()
    {
        $state_id = $this->input->post('state_id', true);
        $cities = $this->location_model->get_cities_by_state($state_id);
        foreach ($cities as $item) {
            echo '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
    }

}