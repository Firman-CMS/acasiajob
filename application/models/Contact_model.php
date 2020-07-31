<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model
{

    //input values
    public function input_values()
    {
        $data = array(
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'message' => $this->input->post('message', true)
        );
        return $data;
    }

    //add contact message
    public function add_contact_message()
    {
        $data = $this->input_values();
        //send email
        if ($this->general_settings->send_email_contact_messages == 1) {
            $this->load->model("email_model");
            $this->email_model->send_email_contact_message($data["name"], $data["email"], $data["message"]);
        }
        $data["created_at"] = date('Y-m-d H:i:s');
        return $this->db->insert('contacts', $data);
    }

    //get unread messages
    public function get_unread_messages()
    {
        $this->db->where('is_read', 0);
        $this->db->where('status', 1);
        $query = $this->db->get('contacts');
        return $query->result();
    }

    //get unread messages
    public function update_unread_to_read()
    {
        $data = ['is_read' => 1];
        $this->db->where('is_read', 0);
        $this->db->where('status', 1);
        return $this->db->update('contacts', $data);
    }

    //get contact messages
    public function get_contact_messages()
    {
        $this->db->where('status', 1);
        $query = $this->db->get('contacts');
        return $query->result();
    }

    //get contact message
    public function get_contact_message($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('contacts');
        return $query->result();
    }

    //get last contact messages
    public function get_last_contact_messages()
    {
        $this->db->limit(5);
        $query = $this->db->get('contacts');
        return $query->result();
    }

    //delete contact message
    public function delete_contact_message($id)
    {
        $id = clean_number($id);
        $contact = $this->get_contact_message($id);
        $data = ['status' => 0];
        if (!empty($contact)) {
            $this->db->where('id', $id);
            return $this->db->update('contacts', $data);
        }
        return false;
    }
}