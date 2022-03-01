<?php
class Product extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('product_model');
	}

	function index()
	{
		//get total product
		$total = $this->product_model->get_total();
		$this->data['total'] = $total;

		//search
		$input = array();
		$id = $this->input->get('id');
		$id = intval($id);
		$input['where'] = array();
		if($id > 0){
			$input['where']['id'] = $id;
		}

		$name = $this->input->get('name');
		if($name){
			$input['like'] = array('name',$name);
		}

		$catalog_id = $this->input->get('catalog');
		$catalog_id = intval($catalog_id);
		if($catalog_id > 0){
			$input['where']['catalog_id'] = $catalog_id;
		}

		//paging product
		$this->load->library('pagination');
		$config = array();
		$config['total_rows'] = $total;
		$config['base_url'] = admin_url('product/index');
		$config['per_page'] = 5;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$segment = $this->uri->segment(4);
		$segment = intval($segment);
		$input['limit'] = array($config['per_page'],$segment);

		//get product
		$select = 'product.id,product.catalog_id,product.name,product.price,product.discount,'.
			'product.image_link,product.created,product.view,product.buyed,catalog.name as catalog_name';
		$join = array(
			array(
				'table' => 'catalog',
				'condition' => 'product.catalog_id = catalog.id'
			),
		);
		$list = $this->product_model->get_list_join($select,$input,$join);
		$this->data['list'] = $list;

		//load catalog
		$this->load->model('catalog_model');
		$input_catalogs = array();
		$input_catalogs['where'] = array('parent_id' => 0);
		$catalogs = $this->catalog_model->get_list($input_catalogs);
		foreach ($catalogs as $row){
			$input_catalogs['where'] = array('parent_id' => $row->id);
			$subs = $this->catalog_model->get_list($input_catalogs);
			$row->subs = $subs;
		}
		$this->data['catalogs'] = $catalogs;

		//check message
		$message = $this->session->flashdata('message');
		$this->data['message'] = $message;

		//load view
		$this->data['temp'] = 'admin/product/index';
		$this->load->view('admin/master_layout',$this->data);
	}

	function add()
	{
		//load catalog
		$this->load->model('catalog_model');
		$input_catalogs = array();
		$input_catalogs['where'] = array('parent_id' => 0);
		$catalogs = $this->catalog_model->get_list($input_catalogs);
		foreach ($catalogs as $row){
			$input_catalogs['where'] = array('parent_id' => $row->id);
			$subs = $this->catalog_model->get_list($input_catalogs);
			$row->subs = $subs;
		}
		$this->data['catalogs'] = $catalogs;

		if($this->input->post()){
			$this->load->library('form_validation');
			$this->load->helper('form');

			$this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('catalog_id','Catalog','required');
			$this->form_validation->set_rules('price','T','required');

			if($this->form_validation->run()){
				$name = $this->input->post('name');
				$catalog_id = $this->input->post('catalog_id');
				$price = $this->input->post('price');
				$price = str_replace(',','',$price);
				$discount = $this->input->post('discount');
				$discount = str_replace(',','',$discount);

				//upload main image
				$this->load->library('upload_library');
				$upload_path = './upload/product';
				$upload_data = $this->upload_library->upload($upload_path,'image');
				$image_link = '';
				if(isset($upload_data['file_name'])){
					$image_link = $upload_data['file_name'];
				}

				//upload sub image
				$image_list = $this->upload_library->upload_files($upload_path,'image_list');
				$image_list = json_encode($image_list);

				$data = array(
					'catalog_id' => $catalog_id,
					'name' => $name,
					'price' => $price,
					'image_link' => $image_link,
					'image_list' => $image_list,
					'discount' => $discount,
					'warranty' => $this->input->post('warranty'),
					'gifts' => $this->input->post('gifts'),
					'site_title' => $this->input->post('site_title'),
					'meta_desc' => $this->input->post('meta_desc'),
					'meta_key' => $this->input->post('meta_key'),
					'content' => $this->input->post('content'),
					'created' => now()
				);
				if($this->product_model->create($data)){
					$this->session->set_flashdata('message', 'insert success!');
				}else{
					$this->session->set_flashdata('message', 'insert failed!');
				}
				redirect(admin_url('product'));
			}
		}

		$this->data['temp'] = 'admin/product/add';
		$this->load->view('admin/master_layout',$this->data);
	}

	function edit()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		$id = $this->uri->rsegment('3');
		$id = intval($id);

		$info = $this->product_model->get_info($id);

		if(!$info){
			$this->session->set_flashdata('message','product not exist!');
			redirect(admin_url('product'));
		}

		$this->data['info'] = $info;

		//load catalog
		$this->load->model('catalog_model');
		$input_catalogs = array();
		$input_catalogs['where'] = array('parent_id' => 0);
		$catalogs = $this->catalog_model->get_list($input_catalogs);
		foreach ($catalogs as $row){
			$input_catalogs['where'] = array('parent_id' => $row->id);
			$subs = $this->catalog_model->get_list($input_catalogs);
			$row->subs = $subs;
		}
		$this->data['catalogs'] = $catalogs;

		if($this->input->post()){
			$this->load->library('form_validation');
			$this->load->helper('form');

			$this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('catalog_id','Catalog','required');
			$this->form_validation->set_rules('price','Price','required');

			if($this->form_validation->run()){
				$name = $this->input->post('name');
				$catalog_id = $this->input->post('catalog_id');
				$price = $this->input->post('price');
				$price = str_replace(',','',$price);
				$discount = $this->input->post('discount');
				$discount = str_replace(',','',$discount);

				//upload main image
				$this->load->library('upload_library');
				$upload_path = './upload/product';
				if(isset($_FILES['image'])){
					if(!empty($info->image_link)){
						unlink($upload_path.'/'.$info->image_link);
					}
					$upload_data = $this->upload_library->upload($upload_path,'image');
					$image_link = '';
					if(!empty($upload_data['file_name'])){

						$image_link = $upload_data['file_name'];
					}
				}

				//upload sub image
				if(isset($_FILES['image'])){
					if(!empty($info->image_list)){
						$old_image_list = json_decode($info->image_list);
						foreach ($old_image_list as $row){
							unlink($upload_path.'/'.$row);
						}
					}
					$image_list = $this->upload_library->upload_files($upload_path,'image_list');
					if(!empty($image_list)){
						$image_list = json_encode($image_list);
					}
				}

				$data = array(
					'catalog_id' => $catalog_id,
					'name' => $name,
					'price' => $price,
					'image_link' => $image_link,
					'image_list' => $image_list,
					'discount' => $discount,
					'warranty' => $this->input->post('warranty'),
					'gifts' => $this->input->post('gifts'),
					'site_title' => $this->input->post('site_title'),
					'meta_desc' => $this->input->post('meta_desc'),
					'meta_key' => $this->input->post('meta_key'),
					'content' => $this->input->post('content'),
					'created' => now()
				);

				if($this->product_model->update($id,$data)){
					$this->session->set_flashdata('message', 'update success!');
				}else{
					$this->session->set_flashdata('message', 'update failed!');
				}
				redirect(admin_url('product'));
			}
		}

		$this->data['temp'] = 'admin/product/edit';
		$this->load->view('admin/master_layout',$this->data);
	}

	function delete()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		$id = $this->uri->rsegment('3');
		$id = intval($id);

		$info = $this->product_model->get_info($id);
		if(!$info){
			$this->session->set_flashdata('message','admin not exist!');
			redirect(admin_url('admin'));
		}
		$upload_path = './upload/product';
		if(!empty($info->image_link)){
			unlink($upload_path.'/'.$info->image_link);
		}
		if(!empty($info->image_list)){
			$old_image_list = json_decode($info->image_list);
			foreach ($old_image_list as $row){
				unlink($upload_path.'/'.$row);
			}
		}
		if($this->product_model->delete($id)){
			$this->session->set_flashdata('message','delete success!');
		}else{
			$this->session->set_flashdata('message', 'delete failed!');
		}
		redirect(admin_url('product'));
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

		$info = $this->product_model->get_info($id);
		if(!$info){
			$this->session->set_flashdata('message','admin not exist!');
			redirect(admin_url('admin'));
		}
		$upload_path = './upload/product';
		if(!empty($info->image_link)){
			unlink($upload_path.'/'.$info->image_link);
		}
		if(!empty($info->image_list)){
			$old_image_list = json_decode($info->image_list);
			foreach ($old_image_list as $row){
				unlink($upload_path.'/'.$row);
			}
		}
		$this->product_model->delete($id);

	}

}
