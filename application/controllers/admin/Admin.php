<?php
class Admin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
	}

	function index()
	{
		$input = array();
		$list = $this->admin_model->get_list($input);
		$this->data['list'] = $list;

		$total = $this->admin_model->get_total();
		$this->data['total'] = $total;

		$message = $this->session->flashdata('message');
		$this->data['message'] = $message;

		$this->data['temp'] = 'admin/admin/index';
		$this->load->view('admin/master_layout',$this->data);
	}

	function add()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		if($this->input->post()){
			$this->form_validation->set_rules('name','name','required|min_length[4]');
			$this->form_validation->set_rules('username','username','required|min_length[4]|callback_check_username');
			$this->form_validation->set_rules('password','password','required|min_length[4]');
			$this->form_validation->set_rules('pass_conf','pass confirm','required|min_length[4]|matches[password]');

			if($this->form_validation->run()){
				$username = $this->input->post('username');
				$name = $this->input->post('name');
				$password = $this->input->post('password');

				$data = array(
					'username' => $username,
					'name' => $name,
					'password' => md5($password)
				);
				if($this->admin_model->create($data)){
					$this->session->set_flashdata('message', 'insert success!');
				}else{
					$this->session->set_flashdata('message', 'insert failed!');
				}
				redirect(admin_url('admin'));
			}
		}

		$this->data['temp'] = 'admin/admin/add';
		$this->load->view('admin/master_layout',$this->data);
	}

	function edit()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		$id = $this->uri->rsegment('3');
		$id = intval($id);

		$info = $this->admin_model->get_info($id);
		if(!$info){
			$this->session->set_flashdata('message','admin not exist!');
			redirect(admin_url('admin'));
		}
		$this->data['info'] = $info;

		if($this->input->post()){
			$this->form_validation->set_rules('name','name','required|min_length[4]');
			$this->form_validation->set_rules('username','username','required|min_length[4]');
			$password = $this->input->post('password');
			if($password){
				$this->form_validation->set_rules('password','password','min_length[4]');
				$this->form_validation->set_rules('pass_conf','pass confirm','required|min_length[4]|matches[password]');
			}
			if($this->form_validation->run()){
				$username = $this->input->post('username');
				$name = $this->input->post('name');
				$password = $this->input->post('password');

				$data = array(
					'username' => $username,
					'name' => $name
				);
				if($password){
					$data['password'] = md5($password);
				}
				if($this->admin_model->update($id,$data)){
					$this->session->set_flashdata('message', 'update success!');
				}else{
					$this->session->set_flashdata('message', 'update failed!');
				}
				redirect(admin_url('admin'));
			}
		}
		$this->data['temp'] = 'admin/admin/edit';
		$this->load->view('admin/master_layout',$this->data);
	}

	function delete()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		$id = $this->uri->rsegment('3');
		$id = intval($id);

		$info = $this->admin_model->get_info($id);
		if(!$info){
			$this->session->set_flashdata('message','admin not exist!');
			redirect(admin_url('admin'));
		}
		if($this->admin_model->delete($id)){
			$this->session->set_flashdata('message','delete success!');
		}else{
			$this->session->set_flashdata('message', 'delete failed!');
		}
		redirect(admin_url('admin'));
	}

	function check_username()
	{
		$username = $this->input->post('username');
		$where = array('username' => $username);
		if($this->admin_model->check_exists($where)){
			$this->form_validation->set_message(__FUNCTION__,'username already exist');
			return false;
		}
		return true;
	}

	function logout()
	{
		if($this->session->userdata('login')){
			$this->session->unset_userdata('login');
		}
		redirect(admin_url('login'));
	}
}
