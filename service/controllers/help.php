<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @帮助中心
 * @author zhoushuai
 * @date 2014-03-25 16:30
 */
class Help extends Help_Controller
{


    public function __construct()
    {

        parent::__construct();
        //$this->lang->load('help');
    }

    public function index()
    {
        $data['help'] = $this->help();
        $this->load->view('help', $data);
    }

    public function infor()
    {
        $this->load->library('input');
        $hid = $this->input->get('h');
        $content = $this->content();
        if (key_exists(trim($hid), $content)) {
            $con = $content[$hid];
            $data['help'] = $this->help();
            $data['content'] = $con;
            $this->load->view('infor', $data);
        } else {
            show_404();
        }
    }


}

/* End of file Help.php */
/* Location: ./service/controllers/Help.php */
