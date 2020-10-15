<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->return = array('status' => false, 'message' => 'Something wrong');

		$this->load->model("aj_auth_model");
		$this->load->model("aj_user_model");
		$this->load->model("api_email_model");
		// $this->load->model("api_user_model");
	}

	public function register_post(){
		$post = [
			'email' => $this->post('email'),
			'password' => $this->post('password'),
			'firstname' => remove_special_characters($this->post('firstname')),
			'lastname' => remove_special_characters($this->post('lastname')),
		];
		
		if (!$this->aj_auth_model->is_unique_email($post['email'])) {
			$this->return['message'] = "Email ini sudah di pakai !";
		} else {
			$user = $this->aj_auth_model->register($post);
			if ($user) {
				$this->return['status'] = true;
				$this->return['message'] = "Success";
				$this->return['data'] = $user;
			}
		}

		$this->response($this->return);
	}

	public function login_post(){
		$post = [
			'email' => $this->post('email'),
			'password' => $this->post('password'),
			'device_id' => $this->post('device_id')
		];
		try {
			$checkLogin = $this->aj_auth_model->login($post);

			if ($checkLogin) {
				$data = $this->aj_auth_model->get_user_by_email($post['email']);
				$this->return['status'] = true;
				$this->return['message'] = 'success';
				$this->return['data'] = $data;
			}else{
				$this->return['message'] = 'Email atau password salah!';
			}
		} catch (Exception $e) {
			$this->return['message'] = $e->getMessage();
		}

		$this->response($this->return);
	}

	public function forgotpassword_post()
	{
		$email = $this->post('email');

		$user = $this->aj_user_model->get_user_by_email($email);
		if ($user) {
			$sendEmail = $this->api_email_model->send_email_reset_passwords($user->id);
			if ($sendEmail['status']) {
				$this->return['status'] = true;
				$this->return['message'] = 'success';
			} else {
				$this->return['message'] = $sendEmail['message'];
			}
		} else {
			$this->return['message'] = "Kami tidak dapat menemukan pengguna dengan alamat email itu!";
		}
		
		$this->response($this->return);
	}

	public function FunctionName($value='')
	{
		$config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'ptacasia57@gmail.com',
            'smtp_pass' => 'abigail5757',
            'smtp_timeout' => 30,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );

        $this->email->initialize($config);

        //send email
        $message = $this->load->view($data['template_path'], $data, TRUE);
        $this->email->from($settings->mail_username, $settings->application_name);
        $this->email->to($data['to']);
        $this->email->subject($data['subject']);
        $this->email->message($message);

        $this->email->set_newline("\r\n");

        if ($this->email->send()) {
            return true;
        } else {
            $this->session->set_flashdata('error', $this->email->print_debugger(array('headers')));
            return false;
        }
	}
}
?>
