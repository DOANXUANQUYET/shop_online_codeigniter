<?php
class Upload_library
{
	var $CI = '';
	function __construct()
	{
		$this->CI = & get_instance();
	}

	/*
	 *Upload file
	 */
	function upload($upload_path = '',$file_name)
	{
		$config = $this->config($upload_path);
		$this->CI->load->library('upload',$config);
		if($this->CI->upload->do_upload($file_name)){
			$data = $this->CI->upload->data();
		}else{
			$data = $this->CI->upload->display_errors();
		}
		return $data;
	}

	/*
	 *Upload multiple file
	 */
	function upload_files($upload_path = '',$file_name = '')
	{
		$config = $this->config($upload_path);
		$this->CI->load->library('upload',$config);

		$files = $_FILES[$file_name];
		$count = count($files['name']);

		$file_list = array();
		for($i = 0; $i < $count; $i++){
			$_FILES['userfile']['name'] = $files['name'][$i]; 			//khai báo tên file
			$_FILES['userfile']['type'] = $files['type'][$i];			//khai báo kiểu của file
			$_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];	//khai báo đường dẫn tạm của file
			$_FILES['userfile']['error'] = $files['error'][$i];			//khai báo lỗi của file
			$_FILES['userfile']['size'] = $files['size'][$i];			//khai báo kích cỡ của file

			if($this->CI->upload->do_upload()){
				$data = $this->CI->upload->data();
				$file_list[] = $data['file_name'];
			}
		}
		return $file_list;
	}

	/*
	 *config upload
	 */
	function config($upload_path = '')
	{
		$config = array();
		$config['upload_path'] = $upload_path;		//thư mục chứa file
		$config['allowed_types'] = 'jpg|png|gif';	//định dạng file được phép tải
		$config['max_size'] = '5000';				//dung lượng tối đa
		$config['max_with'] = '1600';				//chiều rộng tối đa
		$config['max_height'] = '1600';				//chiều cao tối đa

		return $config;
	}
}
