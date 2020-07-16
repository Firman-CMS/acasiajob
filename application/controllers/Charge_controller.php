<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Charge_controller extends Home_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Set your server key (Note: Server key for sandbox and production mode are different)
        $paymentSettings = getPaymentSetting();
        
        $isEnable = $paymentSettings->midtrans_enabled == true ?: false;
        $is_production = $paymentSettings->midtrans_mode == 'live' ? true : false;
        $keyUrl = 'snap/v1/transactions';
        
        $server_key = $is_production ? $paymentSettings->midtrans_server_key_live : $paymentSettings->midtrans_server_key_sandbox;
        
        $api_url = $is_production ? $paymentSettings->midtrans_api_url_live . $keyUrl : $paymentSettings->midtrans_api_url_sandbox . $keyUrl;
        
        if (!$isEnable || !$server_key || !$api_url) {
            http_response_code(404);
            echo "Make sure payment method is enabed / server key  and api url"; exit();
        }

        // Check if request doesn't contains `/charge` in the url/path, display 404
        // if( !strpos($_SERVER['REQUEST_URI'], '/charge') ) {
        //     http_response_code(404); 
        //     echo "wrong path, make sure it's `/charge`"; exit();
        // }

        // Check if method is not HTTP POST, display 404
        if( $_SERVER['REQUEST_METHOD'] !== 'POST'){
            http_response_code(404);
            echo "Page not found or wrong HTTP request method is used"; exit();
        }

        // get the HTTP POST body of the request
        $request_body = file_get_contents('php://input');
        // set response's content type as JSON
        header('Content-Type: application/json');
        // call charge API using request body passed by mobile SDK
        $charge_result = $this->chargeAPI($api_url, $server_key, $request_body);
        // set the response http status code
        http_response_code($charge_result['http_code']);
        // then print out the response body
        echo $charge_result['body'];

        // $this->response($this->return);
    }

    /**
     * call charge API using Curl
     * @param string  $api_url
     * @param string  $server_key
     * @param string  $request_body
     */
    private function chargeAPI($api_url, $server_key, $request_body)
    {
        $ch = curl_init();
        $curl_options = array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            // Add header to the request, including Authorization generated from server key
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($server_key . ':')
            ),
            CURLOPT_POSTFIELDS => $request_body
        );
        curl_setopt_array($ch, $curl_options);
        $result = array(
            'body' => curl_exec($ch),
            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        );
        return $result;
    }
}
