<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . "third_party/swiftmailer/vendor/autoload.php";
require APPPATH . "third_party/phpmailer/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Api_email_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->model("api_general_settings");
        $this->load->model("settings_model");
    }

    public function send_email_activation($user_id)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_token();
                $data = array(
                    'token' => $token
                );
                $this->db->where('id', $user->id);
                $this->db->update('users', $data);
            }

            $data = array(
                'subject' => trans("confirm_your_email"),
                'to' => $user->email,
                'template_path' => "email/email_activation_api",
                'token' => $token,
                'general_settings' => $this->api_general_settings->getAll(),
                'settings' => $this->settings_model->get_settings('2'),
                'lang_base_url' => base_url()
            );

            $this->send_email($data);
        }
    }

    //send email reset password
    public function send_email_reset_password($user_id)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_token();
                $data = array(
                    'token' => $token
                );
                $this->db->where('id', $user->id);
                $this->db->update('users', $data);
            }

            $data = array(
                'subject' => trans("reset_password"),
                'to' => $user->email,
                'template_path' => "email/email_reset_password_api",
                'token' => $token,
                'general_settings' => $this->api_general_settings->getAll(),
                'settings' => $this->settings_model->get_settings('2'),
                'lang_base_url' => base_url()
            );

            $this->send_email($data);
        }
    }

    public function send_email_reset_passwords($user_id)
    {
        $user_id = clean_number($user_id);
        $user = $this->aj_user_model->userData($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_token();
                $data = array(
                    'token' => $token
                );
                $this->db->where('id', $user->id);
                $this->db->update('user', $data);
            }

            $data = array(
                'subject' => trans("reset_password"),
                'to' => $user->email,
                'template_path' => "email/email_reset_password_api",
                'token' => $token,
                'general_settings' => $this->api_general_settings->getAll(),
                'settings' => $this->settings_model->get_settings('2'),
                'lang_base_url' => base_url()
            );

            $send = $this->send_emailer($data);

            return $send;
        }
    }

    public function send_emailer($data)
    {
        // date_default_timezone_set('Etc/UTC');
        // require '../PHPMailerAutoload.php';
        //Membuat instance PHPMailer baru
        // $mail = new PHPMailer;
        $mail = new PHPMailer(true);
        //Memberi tahu PHPMailer untuk menggunakan SMTP
        $mail->isSMTP();
        //Mengaktifkan SMTP debugging
        // 0 = off (digunakan untuk production)
        // 1 = pesan client
        // 2 = pesan client dan server
        $mail->SMTPDebug = 0;
        //HTML-friendly debug output
        $mail->Debugoutput = 'html';
        //hostname dari mail server
        $mail->Host = 'smtp.gmail.com';
        // gunakan
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // jika jaringan Anda tidak mendukung SMTP melalui IPv6
        //Atur SMTP port - 587 untuk dikonfirmasi TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
        // $mail->Port = 465;
        //Set sistem enkripsi untuk menggunakan - ssl (deprecated) atau tls
        $mail->SMTPSecure = 'tls';
        //SMTP authentication
        $mail->SMTPAuth = true;
        //Username yang digunakan untuk SMTP authentication - gunakan email gmail
        $mail->Username = "ptacasia57@gmail.com";
        //Password yang digunakan untuk SMTP authentication
        $mail->Password = "vpqtlolowcnakcin";
        //Email pengirim
        $mail->setFrom('ptacasia57@gmail.com', 'Jobshunter.co.id');
        //Alamat email alternatif balasan
        $mail->addReplyTo('ptacasia57@gmail.com', 'Jobshunter.co.id');
        //Email tujuan
        $mail->addAddress($data['to']);
        //Subject email
        // $mail->Subject = 'PHPMailer GMail SMTP test';
        //Membaca isi pesan HTML dari file eksternal, mengkonversi gambar yang di embed,
        //Mengubah HTML menjadi basic plain-text
        // $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
        //Replace plain text body dengan cara manual
        // $mail->AltBody = 'This is a plain-text message body';
        $mail->isHTML(true);
        $mail->Subject = $data['subject'];
        $mail->Body = $this->load->view($data['template_path'], $data, TRUE, 'text/html');
        //Attach file gambar
        // $mail->addAttachment('images/phpmailer_mini.png');
        //mengirim pesan, mengecek error
        if (!$mail->send()) {
            $datas['status'] = false;
            $datas['message'] = $mail->ErrorInfo;
        } else {
            $datas['status'] = true;
            $datas['message'] = 'success';
        }

        return $datas;
    }

    public function send_email($data)
    {
        if ($this->api_general_settings->getValueOf('mail_library') == "swift") {
            try {
                // Create the Transport
                $transport = (new Swift_SmtpTransport($this->api_general_settings->getValueOf('mail_host'), $this->api_general_settings->getValueOf('mail_port'), 'tls'))
                    ->setUsername($this->api_general_settings->getValueOf('mail_username'))
                    ->setPassword($this->api_general_settings->getValueOf('mail_password'));
                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);
                // Create a message
                $message = (new Swift_Message($this->api_general_settings->getValueOf('application_name')))
                    ->setFrom(array($this->api_general_settings->getValueOf('mail_username') => $this->api_general_settings->getValueOf('application_name')))
                    ->setTo([$data['to'] => ''])
                    ->setSubject($data['subject'])
                    ->setBody($this->load->view($data['template_path'], $data, TRUE), 'text/html');
                //Send the message
                $result = $mailer->send($message);
                if ($result) {
                    return true;
                }
            } catch (\Swift_TransportException $Ste) {
                $this->session->set_flashdata('error', $Ste->getMessage());
                return false;
            } catch (\Swift_RfcComplianceException $Ste) {
                $this->session->set_flashdata('error', $Ste->getMessage());
                return false;
            }
        } elseif ($this->api_general_settings->getValueOf('mail_library') == "php") {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = $this->api_general_settings->getValueOf('mail_host');
                $mail->SMTPAuth = true;
                $mail->Username = $this->api_general_settings->getValueOf('mail_username');
                $mail->Password = $this->api_general_settings->getValueOf('mail_password');
                $mail->SMTPSecure = 'tls';
                $mail->CharSet = 'UTF-8';
                $mail->Port = $this->api_general_settings->getValueOf('mail_port');
                //Recipients
                $mail->setFrom($this->api_general_settings->getValueOf('mail_username'), $this->api_general_settings->getValueOf('application_name'));
                $mail->addAddress($data['to']);
                //Content
                $mail->isHTML(true);
                $mail->Subject = $data['subject'];
                $mail->Body = $this->load->view($data['template_path'], $data, TRUE, 'text/html');
                $mail->send();
                return true;
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $mail->ErrorInfo);
                return false;
            }
        } else {
            $this->load->library('email');

            $settings = $this->settings_model->get_general_settings();
            if ($settings->mail_protocol == "mail") {
                $config = Array(
                    'protocol' => 'mail',
                    'smtp_host' => $settings->mail_host,
                    'smtp_port' => $settings->mail_port,
                    'smtp_user' => $settings->mail_username,
                    'smtp_pass' => $settings->mail_password,
                    'smtp_timeout' => 30,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
            } else {
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => $settings->mail_host,
                    'smtp_port' => $settings->mail_port,
                    'smtp_user' => $settings->mail_username,
                    'smtp_pass' => $settings->mail_password,
                    'smtp_timeout' => 30,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
            }


            //initialize
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
                return false;
            }
        }
    }

}