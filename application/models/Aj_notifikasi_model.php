<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_notifikasi_model extends CI_Model
{
    //add currency
    public function add_notif($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');

        if ($this->db->insert('notifikasi', $data)) {
            return $this->db->insert_id();
        }
    }

    public function update_date($id)
    {
        $data = array(
            'notif_sent' => date("Y-m-d H:i:s"),
        );
        $this->db->where('id', $id);
        $this->db->update('notifikasi', $data);
    }

    //filter by values
    public function filter_company()
    {
        $data = array(
            'q' => $this->input->get('q', true),
        );

        $data['q'] = trim($data['q']);

        if (!empty($data['q'])) {
            $this->db->like('company.company_name', $data['q']);
            $this->db->or_like('company.address', $data['q']);
            $this->db->or_like('company.description', $data['q']);
        }
    }

    public function get_paginated_company_count()
    {
        $this->filter_company();
        $this->db->where('status', 1);
        $query = $this->db->get('company');
        return $query->num_rows();
    }

    public function get_all_company($per_page, $offset)
    {
        $this->filter_company();
        $this->db->where('status', 1);
        $this->db->limit($per_page, $offset);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('company');
        return $query->result();
    }

    //update visual settings
    public function add_new_company()
    {
        $this->load->model('upload_model');
        $file_path = $this->upload_model->logo_company_upload('logo_perusahaan');
        if (!empty($file_path)) {
            $data["picture"] = $file_path;
        }
        $data['company_name'] = $this->input->post('company_name', true);
        $data['address'] = $this->input->post('address', true);
        $data['description'] = $this->input->post('description', true);

        return $this->db->insert('company', $data);
    }

    public function delete_selected_company($id)
    {
        $data = array(
            'status' => 0,
        );
        $this->db->where('id', $id);
        $this->db->update('company', $data);
    }

    public function delete_multi_company($company_id)
    {
        if (!empty($company_id)) {
            foreach ($company_id as $id) {
                $this->delete_selected_company($id);
            }
        }
    }

    public function get_company_by_id($company_id)
    {
        $this->db->where('id', $company_id);
        $this->db->where('status', 1);
        $query = $this->db->get('company');
        return $query->row();
    }

    public function edit_company()
    {
        $id = $this->input->post('id', true);

        $this->load->model('upload_model');
        $file_path = $this->upload_model->logo_company_upload('logo_perusahaan');
        if (!empty($file_path)) {
            $data["picture"] = $file_path;
        }
        $data['company_name'] = $this->input->post('company_name', true);
        $data['address'] = $this->input->post('address', true);
        $data['description'] = $this->input->post('description', true);
        
        $this->db->where('id', $id);
        return $this->db->update('company', $data);
    }

}