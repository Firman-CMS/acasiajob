<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_model extends CI_Model
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
    public function filter_notif()
    {
        $data = array(
            'q' => $this->input->get('q', true),
        );

        $data['q'] = trim($data['q']);

        if (!empty($data['q'])) {
            $this->db->like('notifikasi.title', $data['q']);
            $this->db->or_like('notifikasi.description', $data['q']);
        }
    }

    public function get_paginated_notif_count()
    {
        $this->filter_notif();
        $query = $this->db->get('notifikasi');
        return $query->num_rows();
    }

    public function get_all_notif($per_page, $offset)
    {
        $this->filter_notif();
        $this->db->limit($per_page, $offset);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('notifikasi');
        return $query->result();
    }
}