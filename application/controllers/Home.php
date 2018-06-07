<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{
		$this->load->library('parser');
		$this->parser->parse('line_home',[]);
	}
}
