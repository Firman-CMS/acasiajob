<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_promote_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        
    }


    public function generate_custom_fields_array($category_id, $subcategory_id, $third_category_id, $product_id, $selected_lang)
    {
        
    }

    //execute promote payment stripe
    public function execute_promote_payment_midtrans($data)
    {
        $data['payment_amount'] = price_format_decimal($data['payment_amount']);
        $data['payment_method'] = "Midtrans";
        $data['ip_address'] = $this->input->ip_address();
        $data['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('promoted_transactions', $data);
    }

    

}