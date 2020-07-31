<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_position_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        // $this->load->model("notifikasi_model");
        $this->load->model("aj_position_model");
        $this->load->model("upload_model");
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }

    public function job_position()
    {
    	$data['title'] = trans("job_position");
        $data['position'] = $this->aj_position_model->get_all();
        $data['lang_search_column'] = 2;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/position/list', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function add_new_post()
    {
    	$this->form_validation->set_rules('name', trans("job_position"), 'required|xss_clean|max_length[200]');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors_form', validation_errors());
            redirect($this->agent->referrer());
        } else {
            if ($this->aj_position_model->add_new()) {
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
    	$data['position'] = $this->aj_position_model->get_by_id($id);
        if (empty($data['position'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/position/edit', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function edit_post()
    {
        if ($this->aj_position_model->edit_post()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
                redirect(admin_url() . 'job-position');
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    public function delete_item()
    {
    	$id = $this->input->post('id', true);
        $this->aj_position_model->delete_selected_id($id);
    }

}