<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {
    
	public function index()
	{
	   $this->load->view('about');
	}
    
    public function account_report()
	{
	   $this->load->view('account_report');
	}
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */