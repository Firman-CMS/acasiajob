<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_job_model extends CI_Model
{
	public function add_new()
    {
    	$data = $this->input->post();
    	$data['from'] = date("Y-m-d", strtotime($data['from']));
    	$data['to'] = date("Y-m-d", strtotime($data['to']));
    	return $this->db->insert('job_vacancy', $data);
    }

    //filter by values
    public function filter_job()
    {
        $data = array(
            'q' => $this->input->get('q', true),
        );

        $data['q'] = trim($data['q']);

        if (!empty($data['q'])) {
        	$this->db->like('job_vacancy.title', $data['q']);
            $this->db->or_like('job_vacancy.job_requirement', $data['q']);
            $this->db->or_like('job_vacancy.job_responsibilities', $data['q']);
            $this->db->or_like('job_vacancy.salary', $data['q']);
            $this->db->or_like('job_position.name', $data['q']);
            $this->db->or_like('company.company_name', $data['q']);
            $this->db->or_like('cities.name', $data['q']);
        }
    }

    public function get_paginated_job_count()
    {
        $this->filter_job();
        $this->db->where('job_vacancy.is_deleted', 0);
        $this->db->join('job_position', 'job_vacancy.job_position_id = job_position.id');
        $this->db->join('company', 'job_vacancy.company_id = company.id');
        $this->db->join('cities', 'job_vacancy.city_id = cities.id', 'left');
        $query = $this->db->get('job_vacancy');
        return $query->num_rows();
    }

    public function get_all_job()
    {
    	$this->db->select('job_vacancy.*');
    	$this->db->select('company.company_name');
    	$this->db->select('job_position.name');
    	$this->db->select("cities.name AS 'city_name'");

    	$this->filter_job();

    	$this->db->join('job_position', 'job_vacancy.job_position_id = job_position.id');
        $this->db->join('company', 'job_vacancy.company_id = company.id');
        $this->db->join('cities', 'job_vacancy.city_id = cities.id', 'left');
    	$this->db->where('job_vacancy.is_deleted', 0);
        $this->db->order_by('job_vacancy.status', 'DESC');
        $this->db->order_by('job_vacancy.id', 'ASC');
        $query = $this->db->get('job_vacancy');
        return $query->result();
    }

    public function get_by_id($job_id)
    {
        $this->db->where('id', $job_id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('job_vacancy');
        return $query->row();
    }

    public function edit_post()
    {
    	$id = $this->input->post('id');
    	$data = $this->input->post();
    	$data['from'] = date("Y-m-d", strtotime($data['from']));
    	$data['to'] = date("Y-m-d", strtotime($data['to']));
    	$this->db->where('id', $id);
        return $this->db->update('job_vacancy', $data);
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

    // public function delete_selected_id($id)
    // {
    // 	$data = array(
    //         'is_deleted' => 1,
    //     );
    //     $this->db->where('id', $id);
    //     return $this->db->update('job_position', $data);
    // }


    public function get_company_list()
    {
    	$this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('company');
        $data = $query->result();

        if ($data) {
	        foreach ($data as $value) {
	        	$list[] = [
	        		'label' => $value->company_name,
	        		'value' => $value->id
	        	];
	        }
        } else {
            $list[] = ['label'=> 'Tidak ada list', 'value' => ''];
        }

        return $list;
    }



    public function get_country_list()
    {
        $query = $this->db->get('countries');
        $data = $query->result();

        $list[] = ['label'=> 'Pilih Negara', 'value' => ''];
        foreach ($data as $value) {
        	$list[] = [
        		'label' => $value->name,
        		'value' => $value->id
        	];
        }
        
        return $list;
    }

    public function get_state_list($countryId)
    {
    	$this->db->where('country_id', $countryId);
    	$query = $this->db->get('states');
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

    public function get_cities_list($stateId)
    {
    	$this->db->where('state_id', $stateId);
    	$query = $this->db->get('cities');
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