<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_company_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model("notifikasi_model");
        $this->load->model("aj_notifikasi_model");
        $this->load->model("upload_model");
        // if (!auth_check()) {
        //     redirect(lang_base_url());
        // }
    }

    /**
     * Add new notif
     */
    public function new_company()
    {
        $data['title'] = trans("new_company");
        $data['visual_settings'] = $this->settings_model->get_general_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/company/add_new', $data);
        $this->load->view('admin/includes/_footer');


    }

    public function add_new_post()
    {
        if ($this->aj_notifikasi_model->add_new_company()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    public function list_company()
    {
        $data['title'] = trans("list_company");
        $data['form_action'] = admin_url() . "list-company";
        $pagination = $this->paginate(admin_url() . 'list-company', $this->aj_notifikasi_model->get_paginated_company_count());
        $data['company'] = $this->aj_notifikasi_model->get_all_company($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/company/list_content', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function delete_selected_company()
    {
        $company_id = $this->input->post('id', true);
        $this->aj_notifikasi_model->delete_multi_company($company_id);
    }

    public function delete_company_by_id()
    {
        $id = $this->input->post('id', true);
        $this->aj_notifikasi_model->delete_selected_company($id);
    }

    public function detail_company($id)
    {
        $data['title'] = trans("edit_company");
        $data['company'] = $this->aj_notifikasi_model->get_company_by_id($id);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/company/edit_content', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function edit_post()
    {
        if ($this->aj_notifikasi_model->edit_company()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }
}