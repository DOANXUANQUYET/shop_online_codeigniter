<?php
class Catalog extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('catalog_model');
	}

	function index()
	{
		$input = array();
		$total = $this->catalog_model->get_total();
		$this->data['total'] = $total;

		//paging product
		$this->load->library('pagination');
		$config = array();
		$config['total_rows'] = $total;
		$config['base_url'] = admin_url('catalog/index');
		$config['per_page'] = 8;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$segment = $this->uri->segment(4);
		$segment = intval($segment);
		$input['limit'] = array($config['per_page'],$segment);

		$list = $this->catalog_model->get_list($input);
		$this->data['list'] = $list;

		$message = $this->session->flashdata('message');
		$this->data['message'] = $message;

		$this->data['temp'] = 'admin/catalog/index';
		$this->load->view('admin/master_layout',$this->data);
	}

	function add()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		if($this->input->post()){
			$this->form_validation->set_rules('name','tên','required');
			$this->form_validation->set_rules('sort_order','TT hiển thị','integer');

			if($this->form_validation->run()){
				$sort_order = $this->input->post('sort_order');
				$name = $this->input->post('name');
				$parent_id = $this->input->post('parent_id');

				$data = array(
					'sort_order' => $sort_order,
					'name' => $name,
					'parent_id' => $parent_id
				);
				if($this->catalog_model->create($data)){
					$this->session->set_flashdata('message', 'insert success!');
				}else{
					$this->session->set_flashdata('message', 'insert failed!');
				}
				redirect(admin_url('catalog'));
			}
		}

		$input = array();
		$input['where'] = array('parent_id' => 0);
		$list = $this->catalog_model->get_list($input);
		$this->data['list'] = $list;

		$this->data['temp'] = 'admin/catalog/add';
		$this->load->view('admin/master_layout',$this->data);
	}

	function edit()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		$id = $this->uri->rsegment('3');
		$id = intval($id);

		$info = $this->catalog_model->get_info($id);
		if(!$info){
			$this->session->set_flashdata('message','catalog not exist!');
			redirect(admin_url('catalog'));
		}

		$this->data['info'] = $info;

		if($this->input->post()){
			$this->form_validation->set_rules('name','tên','required');
			$this->form_validation->set_rules('sort_order','TT hiển thị','integer');

			if($this->form_validation->run()){
				$sort_order = $this->input->post('sort_order');
				$name = $this->input->post('name');
				$parent_id = $this->input->post('parent_id');

				$data = array(
					'sort_order' => $sort_order,
					'name' => $name,
					'parent_id' => $parent_id
				);
				if($this->catalog_model->update($id,$data)){
					$this->session->set_flashdata('message', 'update success!');
				}else{
					$this->session->set_flashdata('message', 'update failed!');
				}
				redirect(admin_url('catalog'));
			}
		}

		$input = array();
		$input['where'] = array('parent_id' => 0);
		$list = $this->catalog_model->get_list($input);
		$this->data['list'] = $list;

		$this->data['temp'] = 'admin/catalog/edit';
		$this->load->view('admin/master_layout',$this->data);
	}

	function delete()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		$id = $this->uri->rsegment('3');
		$id = intval($id);

		$info = $this->catalog_model->get_info($id);
		if(!$info){
			$this->session->set_flashdata('message','admin not exist!');
			redirect(admin_url('admin'));
		}

		//check product by catalog
		$this->load->model('product_model');
		$product = $this->product_model->get_info_rule(array('catalog_id' => $id,'id'));
		if(!$product){
			$this->session->set_flashdata('message','This category contains products! You need to delete the product before you can delete this category.!');
			redirect(admin_url('admin'));
		}

		if($this->catalog_model->delete($id)){
			$this->session->set_flashdata('message','delete success!');
		}else{
			$this->session->set_flashdata('message', 'delete failed!');
		}
		redirect(admin_url('catalog'));
	}

	function delete_all()
	{
		$ids = $this->input->post('ids');
		foreach ($ids as $id){
			$this->_delete($id);
		}
	}

	function _delete($id)
	{

		$info = $this->catalog_model->get_info($id);
		if(!$info){
			$this->session->set_flashdata('message','admin not exist!');
			redirect(admin_url('admin'));
		}

		//check product by catalog
		$this->load->model('product_model');
		$product = $this->product_model->get_info_rule(array('catalog_id' => $id,'id'));
		if(!$product){
			$this->session->set_flashdata('message','This category contains products! You need to delete the product before you can delete this category.!');
			redirect(admin_url('admin'));
		}
		$this->catalog_model->delete($id);
	}
}
