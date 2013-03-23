<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE));
        ini_set('date.timezone', 'Asia/Taipei');
	}
     
	public function index()
	{
	   echo "Nothing Here!";	   
	}
    
    function lastest($type="xml")
    {
        $cdn_url = 'http://cdn.22kopendata.org/data/';
        $this->load->database();
        $this->load->helper('xml');
        $time_now = date('Y-m-d H:i:s');
        
        $xml_root = xml_dom();
        $this->db->order_by('id','DESC');
        $this->db->limit(10);
        $query = $this->db->get('salary');
        $count = 0;
        $root_new = xml_add_child($xml_root, 'open22k');
        $infor_tag = xml_add_child($root_new, 'information');
                
        xml_add_child($infor_tag, 'source', '22kopendata.org');
        xml_add_child($infor_tag, 'cached_time', $time_now);
        		
		if ($type == 'json') {
		    header('Content-Type: application/json');
			echo json_encode($query->result());
			exit;
		}
		
        foreach ($query->result() as $row)
        {
            $count = $count + 1;
            $company_name = $row->company_name;
            $location = $row->location;
            $job_name = $row->job_name;
            $salary = $row->salary;
            $notes1 = $row->notes1;
            $notes2 = $row->notes2;
            $data_url = $row->data_url;
            $data_pic_name = $row->data_pic_name;
            $data_file_name = $row->data_file_name;
            
                if ($data_pic_name != '')
                {
                    $data_pic_name = $cdn_url.$data_pic_name;
                }
                
                if ($data_file_name != '')
                {
                    $data_file_name = $cdn_url.$data_file_name;
                }
                //加入item
                $job = xml_add_child($root_new, 'job');
                xml_add_child($job, 'count', $count);
                xml_add_child($job, 'company_name', $company_name);
                xml_add_child($job, 'company_location', $location);
                xml_add_child($job, 'job_name', $job_name);
                xml_add_child($job, 'salary', $salary);
                xml_add_child($job, 'note1', $notes1);
                xml_add_child($job, 'note2', $notes2);
                xml_add_child($job, 'job_url', $data_url);
                xml_add_child($job, 'job_url_screenshot', $data_pic_name);
                xml_add_child($job, 'job_salary_pic', $data_file_name);
        }
        $view_data['xml_data'] = $xml_root;
        $this->load->view('xml_blank',$view_data);
        $this->output->cache(30);
    }
    
    function list_data($per_page = 10,$page_now = 1,$type="xml")
    {
        if ($per_page < 20 && is_numeric($per_page) && $per_page > 0)
        {}
        else
        {
            $per_page = 20;
        }
        
        if (is_numeric($page_now) && $page_now > 0)
        {}
        else
        {
            $page_now = 1;
        }
        $page_no = $page_now;
        $page_now = $page_now-1;
        $cdn_url = 'http://cdn.22kopendata.org/data/';
        $this->load->database();
        $this->load->helper('xml');
        $time_now = date('Y-m-d H:i:s');
        
        $xml_root = xml_dom();
        $this->db->order_by('id','DESC');
        $this->db->limit($per_page,$per_page*$page_now);
        $query = $this->db->get('salary');
        $count = 0;
        $root_new = xml_add_child($xml_root, 'open22k');
        $infor_tag = xml_add_child($root_new, 'information');
                
        xml_add_child($infor_tag, 'source', '22kopendata.org');
        xml_add_child($infor_tag, 'cached_time', $time_now);
        xml_add_child($infor_tag, 'items_per_page', $per_page);
        xml_add_child($infor_tag, 'page_now', $page_no);
        
		if ($type == 'json') {
		    header('Content-Type: application/json');
			echo json_encode($query->result());
			exit;
		}

		
        foreach ($query->result() as $row)
        {
            $count = $count + 1;
            $company_name = $row->company_name;
            $location = $row->location;
            $job_name = $row->job_name;
            $salary = $row->salary;
            $notes1 = $row->notes1;
            $notes2 = $row->notes2;
            $data_url = $row->data_url;
            $data_pic_name = $row->data_pic_name;
            $data_file_name = $row->data_file_name;
            
                if ($data_pic_name != '')
                {
                    $data_pic_name = $cdn_url.$data_pic_name;
                }
                
                if ($data_file_name != '')
                {
                    $data_file_name = $cdn_url.$data_file_name;
                }
                //加入item
                $job = xml_add_child($root_new, 'job');
                xml_add_child($job, 'count', $count);
                xml_add_child($job, 'company_name', $company_name);
                xml_add_child($job, 'company_location', $location);
                xml_add_child($job, 'job_name', $job_name);
                xml_add_child($job, 'salary', $salary);
                xml_add_child($job, 'note1', $notes1);
                xml_add_child($job, 'note2', $notes2);
                xml_add_child($job, 'job_url', $data_url);
                xml_add_child($job, 'job_url_screenshot', $data_pic_name);
                xml_add_child($job, 'job_salary_pic', $data_file_name);
        }
        $view_data['xml_data'] = $xml_root;
        $this->load->view('xml_blank',$view_data);
        $this->output->cache(30);
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */