<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

class Aj_user_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->helper('api_helper');
        // $this->load->model("aj_notifikasi_model");
        // $this->load->model("aj_category_model");
        // $this->load->model("aj_position_model");
        // $this->load->model("upload_model");
        // $this->load->model("location_model");
        $this->load->model("aj_job_applied_model");
        $this->load->model("aj_job_model");
        $this->load->model("aj_user_model");
        $this->load->model("aj_edu_exper_model");
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }

    public function user_profile($userId, $opsi = 'view', $folderName = null)
    {
    	// print_r($folderName);
    	// die;
        $dataUser = $this->aj_user_model->userData($userId);
        if ($dataUser) {
        	$dompdf = new Dompdf(array('enable_remote' => true));
            $dataUser->picture = getPicturePath($dataUser->picture);
            $dataUser->cv = getCvPath($dataUser->cv);

            $userEdu = $this->aj_edu_exper_model->get_user_edu($userId);
            $userExper = $this->aj_edu_exper_model->get_user_exper($userId);
            $dataExper = [];
            if ($userExper) {
                foreach ($userExper as $exper) {
                    $exper->start_date = date("M Y",strtotime($exper->start_date));
                    $exper->end_date = $exper->end_date == 0 ? '' : date("M Y",strtotime($exper->end_date));
                    $duration = $exper->still_work_here ? $exper->start_date .' - Sekarang' : $exper->end_date;
                    $exper->duration = $duration;
                    $dataExper[] = $exper;
                }
            }

            $data['bio'] = (array) $dataUser;
            $data['education'] = (array) $userEdu;
            $data['experience'] = $dataExper;
            $data['url'] = base_url();
            $data['folder'] = $folderName;

            $data['jobTitle'] = '';
            if ($dataExper) {
            	$data['jobTitle'] = (array) $dataExper[0];
            }

            // $dompdf = new Dompdf(array('enable_remote' => true));
		    $this->load->library('pdf');
		    $this->pdf->setPaper('A4', 'potrait');
		    $this->pdf->filename = "profile-".$dataUser->firstname;

		    if ($opsi == 'download') {
		    	// $this->pdf->download('admin/user/user_profile', $data);
		    	$this->downloadPdf('admin/user/user_profile', $data);
		    } else {
		    	$this->pdf->load_view('admin/user/user_profile', $data);
		    }
        }
    }

    public function dowload_profile($jobId)
    {
        $data['title'] = trans("detail_job");
        $job = $this->aj_job_model->get_by_id($jobId);
        if (empty($job)) {
            redirect($this->agent->referrer());
        }
        $folderName = $job->company_name.'-'.$job->title;
        $applied = $this->aj_job_applied_model->get_by_job_id($jobId, 'user_id');

        $error_message = [];
        $errorstatus = 0;
        foreach ($applied as $user) {
            $userId = $user->user_id;
            $userData = $this->user_profile($userId, 'download', $folderName);
        }

        $this->dowloadZip($job->company_name, $job->title);
    }

    public function downloadPdf($view, $data)
    {
    	$dateNow = date('dMy');
    	$file_dir = './download/profile/'.$dateNow.'/'.$data['folder'].'/';
	    if (!is_dir($file_dir)) {
	        mkdir($file_dir, 0777, true);
	    }

    	$dompdf = new DOMPDF();
    	$html = $this->load->view($view, $data, true);
		$dompdf->load_html($html);
		$dompdf->render();
		$output = $dompdf->output();
		file_put_contents($file_dir . $data['bio']['email'] . '.pdf', $output);
		unset($dompdf);
    }

    public function dowloadZip($companyName, $jobTitle)
    {
        $dateNow = date('dMy');
        $folderDir = $companyName.'-'.$jobTitle;
        $dir = 'download/profile/'.$dateNow.'/'.$folderDir;

        $this->load->library('zip');
        $this->zip->compression_level = 0;
        $datas = $this->zip->read_dir($dir);

        $this->zip->download($folderDir.'.zip');
    }
}


