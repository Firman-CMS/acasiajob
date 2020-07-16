<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/simple_html_dom.php';

class Fabelio_controller extends Core_Controller
{
    public function __construct(){
        parent::__construct();
        $this->return = array('status' => false, 'message' => 'Something wrong');

        $this->load->helper('curl_helper');
        $this->load->model("fabelio_model");
    }

    public function index()
    {
        $this->load->view('Fabelio/input_url');
    }

    public function result()
    {
        $url = $this->input->post('url');

        @$html = file_get_html($url);
        if($html === FALSE) {
            $this->return['message'] = "404";
            echo json_encode($this->return);
            exit;
        }

        $productId = '';
        if ($html) {
            $productIdEl = $html->find('input[id="productId"]');
            $productId = $productIdEl[0]->value;
        }


        if ($productId) {
            $siteData = getCurl($productId);
            $siteData = json_decode($siteData);
            $data = $siteData->product;
            $data->product_id = $productId;

            $insertData = $this->fabelio_model->insertData($data);

            if ($insertData) {
                $list['data'] = $data;
                $this->load->view('Fabelio/page3', $list);
            }
        }

        // echo($this->return);
    }

    public function list()
    {
        $list['data'] = $this->fabelio_model->getList();

        if ($list['data']) {
            $this->load->view('Fabelio/list', $list);
        }
    }
}
