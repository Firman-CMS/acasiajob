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
}