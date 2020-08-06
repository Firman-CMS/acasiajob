<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_auth_model extends CI_Model
{
	//check if email is unique
    public function is_unique_email($email)
    {
        $user = $this->get_user_by_email($email);
        if (empty($user)) {
            return true;
        } else {
            return false;
        }
    }

    //get user by email
    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('user');
        return $query->row();
    }

    public function login($post)
    {
        $this->load->library('bcrypt');

        $user = $this->get_user_by_email($post['email']);
        if ($user) {
            if (!$this->bcrypt->check_password($post['password'], $user->password)) {
                return false;
            }
            if ($user->status != 1) {
                return false;
            }
            
            $dataInsert = ['device_id' => $post['device_id']];
        	if (!$this->insert_data($dataInsert, $user->id)){
        		return false;
        	}

        	return true;
        }else{
        	return false;
        }
    }

    public function register($value='')
    {
    	$this->load->library('bcrypt');
        $data = $this->input->post();
        $data['password'] = $this->bcrypt->hash_password($data['password']);

        $this->load->model('upload_model');
        $dataUpload = [
        	'file_name' => 'cv',
        	'email' => str_replace(".", "_", $data['email']),
        ];
        $file_path = $this->upload_model->cv_upload($dataUpload);
        if (!empty($file_path)) {
            $data["cv"] = $file_path;
        }

        if ($this->db->insert('user', $data)) {
            $last_id = $this->db->insert_id();
            return $this->get_user_by_id($last_id);
        } else {
            return false;
        }
    }

    public function get_user_by_id($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->row();
    }

    public function insert_data($data, $userId)
    {
        $this->db->where('id',$userId);
        $insert = $this->db->update('user',$data);
        if (!$insert){
            return false;
        }
        return true;
    }

	public function add_category()
    {
    	$data = $this->input->post();
    	return $this->db->insert('category_job', $data);
    }

    public function get_categories_all()
    {
    	$this->db->where('is_deleted', 0);
        $this->db->order_by('status', 'DESC');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('category_job');
        return $query->result();
    }

    public function get_by_id($id)
    {
    	$this->db->where('id', $id);
    	$this->db->where('is_deleted', 0);
        $query = $this->db->get('category_job');
        return $query->row();
    }

    public function edit_post()
    {
    	$id = $this->input->post('id');
    	$data = $this->input->post();

    	$this->db->where('id', $id);
        return $this->db->update('category_job', $data);
    }

    public function delete_selected_id($id)
    {
    	$data = array(
            'is_deleted' => 1,
        );
        $this->db->where('id', $id);
        return $this->db->update('category_job', $data);
    }

    public function get_category_list()
    {
    	$this->db->where('is_deleted', 0);
    	$this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('category_job');
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