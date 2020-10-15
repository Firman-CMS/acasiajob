<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Profiles extends REST_Controller{

	public function __construct(){
        parent::__construct();
		
        $this->return = array('status' => false, 'message' => 'Something wrong', 'data' => []);
        // $this->load->model("api_file_model");
        $this->load->model("aj_auth_model");
        $this->load->model("aj_edu_exper_model");
        $this->load->model("aj_user_model");
        $this->load->helper('api_helper');
        $this->load->helper('custom_helper');
        $this->product_per_page = 5;
        error_reporting(0);
        ini_set('display_errors', 0);
	}

    public function index_get()
    {
        $userId = $this->get('user_id');
        $dataUser = $this->aj_user_model->userData($userId);
        if ($dataUser) {
            $dataUser->picture = getPicturePath($dataUser->picture);
            $dataUser->cv = getCvPath($dataUser->cv);

            $userEdu = $this->aj_edu_exper_model->get_user_edu($userId);
            $userExper = $this->aj_edu_exper_model->get_user_exper($userId);
            $dataExper = [];
            if ($userExper) {
                foreach ($userExper as $exper) {
                    $exper->start_date = date("M Y",strtotime($exper->start_date));
                    $exper->end_date = $exper->end_date == 0 ? '' : date("M Y",strtotime($exper->end_date));
                    $duration_end = $exper->still_work_here ? 'Sekarang' : $exper->end_date;
                    $duration = $exper->start_date . ' - ' . $duration_end;
                    $exper->duration = $duration;
                    $dataExper[] = $exper;
                    // unset($a->new_property);
                    # code...
                }
            }
            $data['bio'] = $dataUser;
            $data['education'] = $userEdu;
            $data['experience'] = $dataExper;

            $this->return['status'] = true;
            $this->return['message'] = "Success";
            $this->return['data'] = $data;
        }

        $this->response($this->return);
    }

    /*
    * Edit Biodata User
    */
    public function bio_post()
    {
        $userId = $this->post();
        print_r($userId);
        // $this->aj_edu_exper_model->add_edu()
    }

    public function experience_post()
    {
        $data = $this->post();
        $save = $this->aj_edu_exper_model->add_exper();

        if ($save) {
            $this->return['status'] = true;
            $this->return['message'] = "Success";
            unset($this->return['data']);
        }
        $this->response($this->return);
    }

    public function detail_exper_get()
    {
        $userId = $this->get('user_id');
        $eduId = $this->get('exp_id');
        $data = $this->aj_edu_exper_model->get_user_exper_by_id($userId, $eduId);
        if ($data) {
            $data->start_date = date("Y-m-d",strtotime($data->start_date));
            $data->end_date = $data->end_date == 0 ? '' : date("Y-m-d",strtotime($data->end_date));
            $this->return['status'] = true;
            $this->return['message'] = "Success";
            $this->return['data'] = $data;
        }
        
        $this->response($this->return);
    }

    public function experience_edit_post()
    {
        $edit = $this->aj_edu_exper_model->edit_post_exper();
        if ($edit) {
            $this->return['status'] = true;
            $this->return['message'] = "Success";
            unset($this->return['data']);
        }

        $this->response($this->return);
    }

    public function experience_del_post()
    {
        $userId = $this->post('user_id');
        $expId = $this->post('exp_id');
        $update = $this->aj_edu_exper_model->delete_selected_id_exper($expId, $userId);
        if ($update) {
            $this->return['status'] = true;
            $this->return['message'] = "Success";
            unset($this->return['data']);
        }

        $this->response($this->return);
    }

    public function education_post()
    {
        $data = $this->post();
        foreach ($data as $value) {
            if (!$value) {
                $this->return['message'] = 'Lengkapi Data';
                unset($this->return['data']);
                return $this->response($this->return);
            }
        }
        try
        {
            $save = $this->aj_edu_exper_model->add_edu();
            $this->return['status'] = true;
            $this->return['message'] = "Success";
            unset($this->return['data']);
        }
        catch (\Exception $e)
        {
            $this->return['data'] = $e->getMessage();
        }
        
        $this->response($this->return);
    }

    public function detail_education_get()
    {
        $userId = $this->get('user_id');
        $eduId = $this->get('edu_id');
        $data = $this->aj_edu_exper_model->get_user_edu_by_id($userId, $eduId);
        if ($data) {
            $this->return['status'] = true;
            $this->return['message'] = "Success";
            $this->return['data'] = $data;
        }

        $this->response($this->return);
    }

    public function education_edit_post()
    {
        $edit = $this->aj_edu_exper_model->edit_post_edu();
        if ($edit) {
            $this->return['status'] = true;
            $this->return['message'] = "Success";
            unset($this->return['data']);
        }

        $this->response($this->return);
    }

    public function education_del_post()
    {
        $userId = $this->post('user_id');
        $eduId = $this->post('edu_id');
        $update = $this->aj_edu_exper_model->delete_selected_id_edu($eduId, $userId);
        if ($update) {
            $this->return['status'] = true;
            $this->return['message'] = "Success";
            unset($this->return['data']);
        }

        $this->response($this->return);
    }

    public function change_cv_post()
    {
        $userId = $this->post('user_id');
        $uploadCv = $this->aj_auth_model->uploadCv($userId);
        if ($uploadCv) {
            $change = $this->aj_user_model->updateUserData($uploadCv, $userId);
            if ($change) {
                $this->return['status'] = true;
                $this->return['message'] = "Success";
                unset($this->return['data']);
            }
        }
        $this->response($this->return);
    }

    public function change_profil_pic_post()
    {
        $userId = $this->post('user_id');
        $uploadPic = $this->aj_user_model->uploadAvatar($userId);
        if ($uploadPic) {
            $this->return['status'] = true;
            $this->return['message'] = "Success";
            unset($this->return['data']);
        }
        $this->response($this->return);
    }

    public function change_bio_post()
    {
        $data = $this->post();
        $data['id'] = $data['user_id'];
        unset($data['user_id']);
        $change = $this->aj_user_model->updateUserData($data, $data['id']);
        if ($change) {
            $this->return['status'] = true;
            $this->return['message'] = "Success";
            unset($this->return['data']);
        }
        $this->response($this->return);
    }
}