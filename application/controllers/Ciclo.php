<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Error_views.php';
class Ciclo extends Error_views{

	function __construct(){
		parent::__construct();
		$this->load->helper("url"); 
		$this->load->model("mbolsa");
		$this->load->model("meventos");
	}

	public function fn_getCiclosDeCarrera(){
		
	}
}
