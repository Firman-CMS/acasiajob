<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_category_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        // $this->load->model("aj_notifikasi_model");
        $this->load->model("aj_category_model");
        $this->load->model("upload_model");
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }

    public function job_category()
    {
    	$data['title'] = trans("categories");
        $data['categories'] = $this->aj_category_model->get_categories_all();
        $data['lang_search_column'] = 2;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/category/list', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function add_new_post()
    {
    	$this->form_validation->set_rules('name', trans("category_name"), 'required|xss_clean|max_length[200]');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors_form', validation_errors());
            redirect($this->agent->referrer());
        } else {
            if ($this->aj_category_model->add_category()) {
                $this->session->set_flashdata('success_form', trans("msg_category_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error_form', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    public function edit($id)
    {
    	$data['title'] = trans("update_category");
    	$data['category'] = $this->aj_category_model->get_by_id($id);
        if (empty($data['category'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/category/edit', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function edit_post()
    {
        if ($this->aj_category_model->edit_post()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
                redirect(admin_url() . 'job-categories');
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    public function delete_item()
    {
    	$id = $this->input->post('id', true);
        $this->aj_category_model->delete_selected_id($id);
    }

}