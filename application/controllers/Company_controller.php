<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model("notifikasi_model");
        // if (!auth_check()) {
        //     redirect(lang_base_url());
        // }
    }

    /**
     * Add new notif
     */
    public function new_notif()
    {
        $data['title'] = trans("new_notif");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/notif/add_new_notif');
        $this->load->view('admin/includes/_footer');
    }

    public function notif_history()
    {
        $data['title'] = trans("notif_history");
        $data['form_action'] = admin_url() . "notif-history";
        $pagination = $this->paginate(admin_url() . 'deleted-products', $this->product_admin_model->get_paginated_deleted_products_count('deleted_products'));
        $pagination2 = $this->paginate(admin_url() . 'notif-history', $this->notifikasi_model->get_paginated_notif_count());
        $data['products'] = $this->notifikasi_model->get_all_notif($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/notif/list_content', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function add_notif_post()
    {
        $this->form_validation->set_rules('title', 'title', 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('description', 'description', 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $data = [
                'title' => $this->input->post('title', true),
                'description' => $this->input->post('description', true)
            ];

            $idNotif = $this->notifikasi_model->add_notif($data);
            if ($idNotif) {
                $this->session->set_flashdata('success', trans("msg_notif_added"));
                $sendData = [
                    'title' => $data['title'],
                    'message' => $post['description']
                ];
                notifUpdateNews($sendData);

                $this->notifikasi_model->update_date($idNotif);

                $this->session->set_flashdata('success', trans("msg_notif_sent"));
                redirect(admin_url() . 'notif-history');
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }

            redirect($this->agent->referrer());
        }
    }
}