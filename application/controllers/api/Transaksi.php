<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Transaksi extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->return = array('status' => false, 'message' => 'Something wrong');
		$this->load->helper('custom_helper');
	}

	public function index_get(){
		$userId = $this->get('user_id');
		$page = $this->get('page') ?: '1';
        $perPage = $this->get('per_page') ?: '15';
        $offset = $perPage * ($page - 1);

		$listTransaksi = $this->order_model->get_paginated_transaksi($userId, $perPage, $offset);
		$dataTransaksi = [];
		foreach ($listTransaksi as $transaksi) {
			if ($transaksi->payment_method == 'Midtrans') {
				$transaksi->payment_status = $this->getStatusMidtrans($transaksi->payment_id);
			} elseif ($transaksi->payment_method == 'Ipaymu online') {
				$transaksi->payment_status = $this->getStatusIpaymu($transaksi->payment_id);
			}
			$dataTransaksi[] = $transaksi;
		}

		if ($userId) {
			$this->return['status'] = true;
			$this->return['message'] = "Success";
			$this->return['data'] = $dataTransaksi;
		}
		
		$this->response($this->return);

	}

	public function getStatusMidtrans($paymentId)
	{
		$paymentSettings = getPaymentSetting();
		$is_production = $paymentSettings->midtrans_mode == 'live' ? true : false;
        $api_url = $is_production ? 'https://api.midtrans.com' : 'https://api.sandbox.midtrans.com';
        $host = $api_url."/v2/".$paymentId."/status";
        $username = $is_production ? $paymentSettings->midtrans_server_key_live.':' : $paymentSettings->midtrans_server_key_sandbox.':';
		$password = '';
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			"Accept: application/json",
			'Content-Type: application/json'
		));
		curl_setopt($curl, CURLOPT_URL, $host);
		curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		// if ($err) {
		//   echo "cURL Error #:" . $err;
		// }
		
		$response = json_decode($response);

		if ($response->status_code == '200' || $response->status_code == '201') {
			return $response->transaction_status;
		}else{
			return "Transaction doesn't exist";
		}
	}

	public function getStatusIpaymu($paymentId)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://my.ipaymu.com/api/transaksi",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => array(
				'key' => '57231044-80B0-4739-8FF8-FFC3C71403AB',
				'id' => $paymentId,
				'format' => 'json'),
			CURLOPT_HTTPHEADER => array(
				"Accept: application/json"
			),
		));

	    $response = curl_exec($curl);
	    $err = curl_error($curl);

	    curl_close($curl);

	    if ($err) {
	      echo "cURL Error #:" . $err;
	    } else {
	      
	    }
	    $response = json_decode($response); 
	    
	    return $response->Keterangan;
	}
}

