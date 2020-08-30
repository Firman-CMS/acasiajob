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
    	if (!$data['city_id']) {
    		$data['city_id'] = null;
    	}
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

    public function get_all_job_active()
    {
        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('job_vacancy');
        return $query->result();
    }

    public function get_latest_job($limit)
    {
        $this->db->select('job_vacancy.*');
    	$this->db->select('company.company_name');
    	$this->db->select('job_position.name');
    	$this->db->select("cities.name AS 'city_name'");

    	$this->db->join('job_position', 'job_vacancy.job_position_id = job_position.id');
        $this->db->join('company', 'job_vacancy.company_id = company.id');
        $this->db->join('cities', 'job_vacancy.city_id = cities.id', 'left');

    	$this->db->where('job_vacancy.is_deleted', 0);
    	$this->db->where('job_vacancy.status', 1);
        $this->db->order_by('job_vacancy.id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('job_vacancy');
        return $query->result();
    }

    public function get_latest_company($limit)
    {
        $this->db->where('status', 1);
        $this->db->limit($limit);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('company');
        return $query->result();
    }

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

    public function get_paginated_filtered_job($per_page, $offset, $data)
    {
    	$today = date('Y-m-d');
        $this->filter_job_list($data);
        $this->db->limit($per_page, $offset);
        $this->db->where('job_vacancy.is_deleted', 0);
    	$this->db->where('job_vacancy.status', 1);
    	$this->db->where('job_vacancy.from <=', $today);
    	$this->db->where('job_vacancy.to >=', $today);
    	$this->db->order_by('job_vacancy.created_at', 'DESC');
        $query = $this->db->get('job_vacancy');
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function filter_job_list($data)
    {
    	$this->db->select( 'job_vacancy.*,
			category_job.name category_name,
			job_position.name position_name,
			cities.name city_name,
			states.name state_name,
			countries.name country_name,
			company.company_name company_name,
			company.picture company_logo'
		);

    	if ($data['search']) {
    		$search = remove_special_characters(trim($data['search']));
    		$this->db->like('job_vacancy.title', $search);
            $this->db->or_like('job_vacancy.job_requirement', $search);
            $this->db->or_like('job_vacancy.job_responsibilities', $search);
            $this->db->or_like('company.company_name', $search);
    	}
    	if ($data['location']) {
    		$location = $this->mappingStateCity($data['location']);
    		if ($location['list_state']) {
    			$this->db->where_in('job_vacancy.state_id', $location['list_state']);
    		}
    		if ($location['list_city']) {
    			$this->db->where_in('job_vacancy.city_id', $location['list_city']);
    		}
    	}
    	if (isset($data['category']) && $data['category']) {
    		$this->db->where('job_vacancy.category_id', $data['category']);
    	}

    	$this->JoinTable($data);
    }

    public function JoinTable($data = null)
    {
    	if (isset($data['area'])) {
			if ($data['area'] == 1) {
				$this->db->where('job_vacancy.country_id', '102');
			} else {
				$this->db->where('job_vacancy.country_id <>', '102');
			}
    	}

    	$this->db->join('category_job','category_job.id = job_vacancy.category_id')
    			->join('job_position','job_position.id = job_vacancy.job_position_id')
    			->join('company','company.id = job_vacancy.company_id')
    			->join('countries','countries.id = job_vacancy.country_id')
    			->join('states','states.id = job_vacancy.state_id', 'left')
    			->join('cities','cities.id = job_vacancy.city_id', 'left');
    }

    public function mappingStateCity($location)
    {
    	$location = explode(",", $location);
    	$state = [];
    	$city = [];
    	foreach ($location as $value) {
    		if ($value[0] == 'p') { #for state/provinsi
    			$data = explode("p",$value);
    			array_push($state, $data[1]);
    		} else {
    			array_push($city, $value);
    		}
    	}

    	$data = [
    		'list_state' => $state,
    		'list_city' => $city
    	];
    	
    	return $data;
    }
    
    public function get_filter_job($data)
    {
    	$today = date('Y-m-d');
        $this->queryFilter($data);
        $this->db->where('job_vacancy.is_deleted', 0);
    	$this->db->where('job_vacancy.status', 1);
    	$this->db->where('job_vacancy.from <=', $today);
    	$this->db->where('job_vacancy.to >=', $today);
        $query = $this->db->get('job_vacancy');
        return $query->result();
    }

    public function queryFilter($data)
    {
    	$this->db->select( 'job_vacancy.*, 
    		category_job.name category_name,
			job_position.name position_name,
			cities.name city_name,
			states.name state_name'
    	);
    	$this->JoinTable($data);
    }

    public function getDetailJob($jobId)
    {
    	$today = date('Y-m-d');
        $this->queryFilterDetail();
        $this->db->where('job_vacancy.is_deleted', 0);
    	$this->db->where('job_vacancy.status', 1);
    	$this->db->where('job_vacancy.from <=', $today);
    	$this->db->where('job_vacancy.to >=', $today);
    	$this->db->where('job_vacancy.id', $jobId);
        $query = $this->db->get('job_vacancy');
        return $query->row();
    }

    public function queryFilterDetail()
    {
    	$this->db->select( 'job_vacancy.*, 
    		company.company_name,
    		company.picture company_logo,
    		company.address company_address,
    		company.description company_overview,
    		category_job.name category_name,
			job_position.name position_name,
			cities.name city_name,
			states.name state_name'
    	);
    	$this->JoinTable(null);
    }

    public function getUserAppliedJob($jobId, $userId)
    {
    	$this->db->where('job_id', $jobId);
    	$this->db->where('user_id', $userId);
    	$query = $this->db->get('job_applied');
    	return $query->row();
    }

    public function applyJob($data)
    {
        $this->db->insert('job_applied', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getAppliedJob($userId)
    {
        $this->db->where('user_id', $userId);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('job_applied');
        return $query->result();
    }

    public function getUserSavedJob($jobId, $userId)
    {
        $this->db->where('job_id', $jobId);
        $this->db->where('user_id', $userId);
        $query = $this->db->get('job_saved');
        return $query->row();
    }

    public function saveJob($data)
    {
        $this->db->insert('job_saved', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getSavedJob($userId)
    {
        $this->db->where('user_id', $userId);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('job_saved');
        return $query->result();
    }
}