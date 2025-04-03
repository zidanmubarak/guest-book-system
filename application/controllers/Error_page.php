<?php
class Error_page extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
	function index(){
		$this->load->view('include/v_head');
		$this->load->view('include/v_error_page');
		$this->load->view('include/v_footer');
	}
}
