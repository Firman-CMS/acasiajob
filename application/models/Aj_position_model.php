<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_position_model extends CI_Model
{
	public function add_new()
    {
    	$data = $this->input->post();
    	return $this->db->insert('job_position', $data);
    }

    public function get_all()
    {
    	$this->db->where('is_deleted', 0);
        $this->db->order_by('status', 'DESC');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('job_position');
        return $query->result();
    }

    public function get_by_id($id)
    {
    	$this->db->where('id', $id);
    	$this->db->where('is_deleted', 0);
        $query = $this->db->get('job_position');
        return $query->row();
    }

    public function edit_post()
    {
    	$id = $this->input->post('id');
    	$data = $this->input->post();

    	$this->db->where('id', $id);
        return $this->db->update('job_position', $data);
    }

    public function delete_selected_id($id)
    {
    	$data = array(
            'is_deleted' => 1,
        );
        $this->db->where('id', $id);
        return $this->db->update('job_position', $data);
    }

    public function get_position_list()
    {
        $this->db->where('is_deleted', 0);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('job_position');
        $data = $query->result();

        if ($data) {
            foreach ($data as $value) {
                $list[] = [
                    'label' => $value->name,
                    'value' => $value->id
                ];
            }
        } else {
            $list[] = ['label'=> 'Tidak ada list', 'value' => ''];
        }
        
        return $list;
    }

}