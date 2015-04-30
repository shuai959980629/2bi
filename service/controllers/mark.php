<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *关注
 * @author zhoushuai
 * @date 2014-03-25 16:30
 */
class Mark extends Mark_Controller 
{


    public function __construct()
    {

        parent::__construct();
        $this->lang->load('mark');
        //$this->load->library('form_validation');
    }

    /**
     * 添加关注
     */

    public function add_mark()
    {
        if ($this->_validate_add_mark() == FALSE) {
            $this->return_client(0, null, strip_tags($this->errors));
        }
        $result = parent::mark($this->filter_params, $this->token['uid']);
        if ($result) {
            $this->return_client(1, $result,null);
        } else {
            $this->return_client(0, null, $this->lang->line('add_mark_fail'));
        }
    }
    /**
     * 取消关注
     */
    public function cancel_mark(){
        if (empty($this->params['uid'])) {
            $this->return_client(0, null, strip_tags($this->lang->line('request_param_errors')));
        }
        $result = parent::cancel_mark($this->params, $this->token['uid']);
        if ($result) {
            $this->return_client(1, $result,null);
        } else {
            $this->return_client(0, null, $this->lang->line('add_mark_fail'));
        }   
    }
    
    /**
     * 获取用户动态
     */
     public function get_dyna(){
        $page = $this->params['page'] ? $this->params['page'] : 1;
        $result = parent::dynlist($this->token['uid'],$page);
        //$result = parent::dynamic($this->token['uid'],$page);
        if (FALSE !== $result) {
            $this->return_client(1, $result,$this->errors);
        }else {
            //$this->lang->line('get_dyna_fail')
            $this->return_client(0, null,$this->errors);
        }  
     }

    
    /**
     * 验证关注 
     */
    private function _validate_add_mark()
    {

        if (empty($this->params['uid'])) {
            $this->errors = $this->lang->line('request_param_errors');
            return false;
        }
        //是否是自己
        if ($this->params['uid'] == $this->token['uid']) {
            $this->errors = $this->lang->line('add_mark_self');
            return false;
        }
        //是否已经关注过，不能重复操作
        $this->load->model('mark_model', 'mark');
        $cancel_data = array('id_2buser' => $this->token['uid'], 'object_id' => $this->params['uid']);
        $res =  $this->mark->check_marked($cancel_data);
        if($res){
            $this->errors = $this->lang->line('add_mark_repeat');
            return false;
        }
        $this->filter_params = $this->params;
        return TRUE;
    }
    
    /**
     * 获取关注列表
     */
    public function get_mark(){
        $page = $this->params['page'] ? $this->params['page'] : 1;
        $result = parent::marklist($this->token['uid'],$page);
        if (FALSE !== $result) {
            $this->return_client(1, $result,$this->errors);
        }else {
            $this->return_client(0, null,$this->errors);
        }  
     }
     
     /**
      * @是否有新的动态信息
      */
     public function new_dyna(){
        $time = key_exists('time',$this->params)?$this->params['time']:'';
        $result = parent::new_dyna($this->token['uid'],$time);
        if (FALSE !== $result) {
            $this->return_client(1, $result,$this->errors);
        }else {
            $this->return_client(0, null,$this->errors);
        } 
        
     }
}

/* End of file Mark.php */
/* Location: ./service/controllers/mark.php */
