<?php
class Home extends CI_Controller
{
	function index()
	{
		$data = array();
		$data['temp'] = 'site/home/index';
		$this->load->view('site/layout_master',$data);
	}
}
