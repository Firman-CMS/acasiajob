<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_blog_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        
    }


    //get paginated posts
    public function get_paginated_posts($per_page, $offset)
    {
        $sitelang = api_lang_helper()->id;
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_posts.lang_id', $sitelang);
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    public function get_paginated_category_posts($per_page, $offset, $category_id)
    {
        $category_id = clean_number($category_id);
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_posts.category_id', $category_id);
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    public function get_latest_posts($limit)
    {
        $limit = clean_number($limit);
        $sitelang = api_lang_helper()->id;
        $this->db->join('blog_categories', 'blog_posts.category_id= blog_categories.id');
        $this->db->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug');
        $this->db->where('blog_posts.lang_id', $sitelang);
        $this->db->limit($limit);
        $this->db->order_by('blog_posts.created_at', 'DESC');
        $query = $this->db->get('blog_posts');
        return $query->result();
    }

    //add comment
    public function add_blog_comment($data)
    {

        if ($data['post_id'] && trim($data['comment'])) {
            if ($data['user_id'] != 0) {
                $user = $this->auth_model->get_user($data['user_id']);
                if (!empty($user)) {
                    $data['name'] = $user->username;
                    $data['email'] = $user->email;
                }
            }
            $this->db->insert('blog_comments', $data);
        }
    }

    /**
     * Delete Comment
     */
    public function delete_comment_post($data)
    {

        $comment = $this->comment_model->get_blog_comment($data['comment_id']);
        
        if ($data['user_id'] == $comment->user_id) {
            $this->comment_model->delete_blog_comment($data['comment_id']);
            return true;
        } else {
            return false;
        }

    }

}
