<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Blog extends REST_Controller{

	public function __construct(){
        parent::__construct();
        $this->return = array('status' => false, 'message' => 'Something wrong', 'data' => []);

        $this->load->model("api_blog_model");
        $this->load->model("api_general_settings");
        $this->load->model("comment_model");
        $this->load->model("blog_model");
        $this->load->helper('api_helper');
        $this->load->helper('custom_helper');
        // error_reporting(0);
        // ini_set('display_errors', 0);
    }

	public function index_get(){
		$page = $this->get('page') ?: '1';
        $perPage = $this->get('per_page') ?: '8';
        $offset = $perPage * ($page - 1);
		$data = $this->api_blog_model->get_paginated_posts($perPage, $offset);
		if ($data) {
			$dataBlog = [];
			foreach ($data as $blog) {
				$blog->time_created = timeAgo($blog->created_at);
				$dataBlog[] = $blog;
			}

			$this->return['status'] = true;
			$this->return['message'] = "Success";
			$this->return['data'] = $dataBlog;
		}

		$this->response($this->return);
	}

	public function tutorial_get()
	{
		$page = $this->get('page') ?: '1';
        $perPage = $this->get('per_page') ?: '8';
        $offset = $perPage * ($page - 1);

        $category = $this->blog_category_model->get_category_by_slug('tutorial');
		$data = $this->api_blog_model->get_paginated_category_posts($perPage, $offset, $category->id);
		if ($data) {
			$dataBlog = [];
			foreach ($data as $blog) {
				$blog->time_created = timeAgo($blog->created_at);
				$dataBlog[] = $blog;
			}

			$this->return['status'] = true;
			$this->return['message'] = "Success";
			$this->return['data'] = $dataBlog;
		}

		$this->response($this->return);
	}

	public function detail_get()
	{
		$slug = $this->get('slug');
		$slug = decode_slug($slug);

        $blog = $this->blog_model->get_post_by_slug($slug);
        if ($blog) {
        	$blog->time_created = timeAgo($blog->created_at);
        	$data['post'] = $blog;
        	
        	$relatedPosts = $this->blog_model->get_related_posts($data['post']->category_id, $data["post"]->id);
        	$dataRelated = [];
        	if ($relatedPosts) {
				foreach ($relatedPosts as $related) {
					$related->time_created = timeAgo($related->created_at);
					$dataRelated[] = $related;
				}
			}
			$data['related_posts'] = $dataRelated;

        // $data['latest_posts'] = $this->api_blog_model->get_latest_posts(3);
        	
        	$comments = $this->comment_model->get_blog_comments($data["post"]->id, 6);
			$dataComments = [];
        	if ($comments) {
				foreach ($comments as $comment) {
					$userOwner = $this->auth_model->get_user($comment->user_id);
					$comment->user_avatar = getAvatar($userOwner);
					$comment->time_created = timeAgo($comment->created_at);
					$dataComments[] = $comment;
				}
			}
			$data['comments'] = $dataComments;
		
			$this->return['status'] = true;
			$this->return['message'] = "Success";
			$this->return['data'] = $data;				
		}

		$this->response($this->return);
	}

	public function comment_post()
	{
		if ($this->api_general_settings->getValueOf('blog_comments') != 1) {
            return $this->response($this->return);
        }
		
		$data = array(
            'post_id' => $this->post('blog_id'),
            'user_id' => $this->post('user_id'),
            'comment' => $this->post('comment'),
            'created_at' => date("Y-m-d H:i:s")
        );

        foreach ($data as $value) {
        	if (!$value) {
        		return $this->response($this->return);
        	}
        }

		$postComment = $this->api_blog_model->add_blog_comment($data);

		$this->return['status'] = true;
		$this->return['message'] = "Success";

		$this->response($this->return);
	}

	public function delcomment_post()
	{
		$data = array(
			'user_id' => $this->post('user_id'),
			'comment_id' => $this->post('comment_id')
		);

		$delComment = $this->api_blog_model->delete_comment_post($data);

		if ($delComment) {
			$this->return['status'] = true;
			$this->return['message'] = "Success";
		}

		$this->response($this->return);
	}
}
?>
