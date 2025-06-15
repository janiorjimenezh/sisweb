<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Itinerario extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('minscrito_egresado');

	}
	
}
