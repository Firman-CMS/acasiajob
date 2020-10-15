<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_user_model extends CI_Model
{
    public function getUserData($attribute, $userId)
    {
        $this->db->select($attribute);
        $this->db->where('id', $userId);
        $query = $this->db->get('user');
        return $query->row();
    }

    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('user');

        return $query->row();
    }

    public function userData($userId)
    {
    	$this->db->where('id', $userId);
        $query = $this->db->get('user');
        return $query->row();
    }

    public function arrayUserData($userIdArray)
    {
    	// $this->db->where('id', $userId);
        $this->filter_user();
    	$this->db->where_in('id', $userIdArray);
        $query = $this->db->get('user');
        return $query->result();
    }

    public function filter_user()
    {
        $data = array(
            'q' => $this->input->get('q', true),
        );

        $data['q'] = trim($data['q']);

        if (!empty($data['q'])) {
            $this->db->like('user.email', $data['q']);
            $this->db->or_like('user.firstname', $data['q']);
            $this->db->or_like('user.lastname', $data['q']);
            $this->db->or_like('user.phone', $data['q']);
        }
    }

    public function updateUserData($DataAttribute, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('user', $DataAttribute);
        return $this->db->affected_rows();
    }

    public function uploadAvatar($userId)
    {
        $this->load->model('upload_model');
        $file_path = $this->upload_model->profile_picture_upload('avatar');
        if (!empty($file_path)) {
            $data["picture"] = $file_path;
            return $this->updateUserData($data, $userId);
        }
        return false;
    }
}