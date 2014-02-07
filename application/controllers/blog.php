<?php

class Blog extends CI_Controller{
	function Blog(){
		parent::__construct();

		$this->load->model('blog_model');
		$this->load->helper('url');
		$this->load->helper('form');
	}

	function index(){
		$data['title'] = "Blog";
		$data['header'] = "This is a heading.";
		$data['name'] = "Developer";
		$data['query'] = $this->blog_model->get_entries('entries');
		
		$this->load->view("blog_view", $data);
	}

	function comments(){
		$data['title'] = "Comments";
		$data['header'] = "Comments";
		$data['query'] = $this->blog_model->get_comments('comments', 'entry_id', $this->uri->segment(3));

		$this->load->view("comment_view", $data);
	}

	function comment_insert(){
		$this->blog_model->insert_comment('comments', $_POST);

		redirect('blog/comments/'.$_POST['entry_id']);
	}
}

?>