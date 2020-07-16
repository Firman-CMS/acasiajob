<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fabelio_model extends CI_Model
{
	public function insertData($data)
	{
		$listData = [
			'name' => $data->name,
			'product_id' => $data->product_id,
			'unit_price' => $data->unit_price,
			'unit_sale_price' => $data->unit_sale_price,
			'url' => $data->url,
			'product_image_url' => $data->product_image_url,
			'created_at' => date('Y-m-d H:i:s')
		];
		
		return $this->db->insert('fabelio', $listData);
	}

	public function getList()
	{
		$this->db->order_by('fabelio.created_at', 'DESC');
        $query = $this->db->get('fabelio');
        return $query->result();
	}
}