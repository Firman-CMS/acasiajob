<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_edu_exper_model extends CI_Model
{
    public function add_edu()
    {
    	$data = $this->input->post();
    	return $this->db->insert('education', $data);
    }

    public function get_user_edu($userId)
    {
    	$this->db->where('is_deleted', 0);
    	$this->db->where('user_id', $userId);
        $this->db->join('education_level', 'education_level.level_id = education.level');
        $this->db->order_by('edu_id', 'DESC');
        $query = $this->db->get('education');
        return $query->result();
    }

    public function get_user_edu_by_id($userId, $eduId)
    {
        $this->db->where('is_deleted', 0);
        $this->db->where('user_id', $userId);
        $this->db->where('edu_id', $eduId);
        $this->db->join('education_level', 'education_level.level_id = education.level');
        $query = $this->db->get('education');
        return $query->row();
    }

    public function edit_post_edu()
    {
    	$data = $this->input->post();

    	$this->db->where('edu_id', $data['edu_id']);
    	$this->db->where('user_id', $data['user_id']);
        $this->db->update('education', $data);
        return $this->db->affected_rows();
    }

    public function delete_selected_id_edu($id, $userId)
    {
    	$data = array(
            'is_deleted' => 1,
        );
        $this->db->where('edu_id', $id);
        $this->db->where('user_id', $userId);
        $this->db->update('education', $data);
        return $this->db->affected_rows();
    }

    public function add_exper()
    {
    	$data = $this->input->post();
    	return $this->db->insert('experience', $data);
    }

    public function get_user_exper($userId)
    {
    	$this->db->select('experience.*');
        $this->db->select('job_position.name position_name');
        $this->db->where('experience.is_deleted', 0);
    	$this->db->where('user_id', $userId);
        $this->db->join('job_position', 'job_position.id = experience.position');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('experience');
        return $query->result();
    }

    public function get_user_exper_by_id($userId, $expId)
    {
        $this->db->select('experience.*');
        $this->db->select('job_position.name position_name');
        $this->db->where('experience.is_deleted', 0);
        $this->db->where('user_id', $userId);
        $this->db->where('exp_id', $expId);
        $this->db->join('job_position', 'job_position.id = experience.position');
        $query = $this->db->get('experience');
        return $query->row();
    }

    public function edit_post_exper()
    {
    	$data = $this->input->post();

        $this->db->where('exp_id', $data['exp_id']);
        $this->db->where('user_id', $data['user_id']);
        $this->db->update('experience', $data);

        return $this->db->affected_rows();
    }

    public function delete_selected_id_exper($id, $userId)
    {
    	$data = array(
            'is_deleted' => 1,
        );
        $this->db->where('exp_id', $id);
        $this->db->where('user_id', $userId);
        $this->db->update('experience', $data);
        return $this->db->affected_rows();
    }
}