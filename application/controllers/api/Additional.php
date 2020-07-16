<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Additional extends REST_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->return = array('status' => false, 'message' => 'Something wrong', 'data' => []);

        $this->load->model("slider_model");
    }
    /*
    * Slider Items
    */
    public function slideritems_get()
    {
        $data = $this->slider_model->get_slider_items_all_api();
        $datas = [];
        if ($data) {
            foreach ($data as $value) {
                $value->bahasa = $value->lang_id == '1' ? 'English' : 'Indonesia';
                $value->image = $value->image ? base_url() . $value->image : '';
                $value->image_small = $value->image_small ? base_url() . $value->image_small : '';
                $datas[] = $value;
            }

            $this->return['status'] = true;
            $this->return['message'] = 'success';
            $this->return['data'] = $datas;
        }

        $this->response($this->return);
    }
    
}
?>