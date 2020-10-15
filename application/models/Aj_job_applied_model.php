<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aj_job_applied_model extends CI_Model
{
    public function get_by_job_id($jobId, $attribute = null, $perPage = null, $offset = null)
    {
    	if ($attribute) {
        	$this->db->select($attribute);
    	}
		$this->db->limit($perPage, $offset);
        $this->db->where('job_id', $jobId);
        $query = $this->db->get('job_applied');
        // print_r($this->db->last_query());
        return $query->result();
    }

    public function getUserApplied($jobId)
    {
    	$this->db->where('job_id', $jobId);
        $query = $this->db->get('job_applied');
        return $query->result();
    }
}