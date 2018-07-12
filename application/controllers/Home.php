<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		$data = [
			'content' => 'home/index'
		];
		$this->load->view('layouts/master', $data, FALSE);
	}

	public function post_index()
	{
		$config = [
			'upload_path' => FCPATH . 'assets/uploads',
			'allowed_types' => 'xlsx|csv|xls'
		];

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('file')) {
			$data = $this->upload->data();
			@chmod($data['full_path'], 0777);
			// var_dump ($data['full_path']);
			// die();
			$this->load->library('Spreadsheet_Excel_Reader');
			$this->spreadsheet_excel_reader->setOutputEncoding('CP1251');

			$this->spreadsheet_excel_reader->read($data['full_path']);
			$sheets = $this->spreadsheet_excel_reader->sheets[0];
			
			;
			die();

			error_reporting(0);

			$data_excel = array();
			for ($i = 2; $i <= $sheets['numRows']; $i++) {
				if ($sheets['cells'][$i][1] == '') break;
				$data_excel[$i - 1]['name']    = $sheets['cells'][$i][1];
				$data_excel[$i - 1]['phone']   = $sheets['cells'][$i][2];
				$data_excel[$i - 1]['address'] = $sheets['cells'][$i][3];
			}

			echo '<pre>';
				print_r($data_excel);
			echo '</pre>';
		}else{
			echo $this->upload->display_errors();
		}

	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */