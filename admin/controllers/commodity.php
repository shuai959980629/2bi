<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台商品管理
 *@version v-1.0
 *@author zhoushuai
 *@copyright 2014-06-18
 */
class Commodity extends Admin_Controller{

	
    public function __construct()
    {
        parent::__construct();
    } 
	
	public function index() {
		$where = '';
	    $this->page_data['title']='邻售商家商品管理';
        $this->page_data['current']='commodity';
		$id_theme = trim($this->input->get('tid'));//专题id
		if(!empty($id_theme)){
			$this->load->model('theme_model','theme');
			$where1 = array('id_theme'=>$id_theme);
			$arrCowry = $this->theme->get_theme_cowry_by_where($where1);
			if($arrCowry){
				$cowry = array();
				foreach($arrCowry as $key=>$val){
					$cowry[]=$val['id_cowry'];
				}
				$cwStr = implode(' ',$cowry);
				$this->page_data['themCowry'] = $cwStr;
				$this->cache_data('themCowry', $cwStr);
				$sqlin = implode(",", $cowry);
				if(preg_match("/^(\d{1,10},)*(\d{1,10})$/", $sqlin)) {
					$where = "ci.id_cowry IN  (" . $sqlin . ")";
				}
			}
			$this->page_data['id_theme'] = $id_theme;
		}
        /**
         * @第一步：获取商品列表。分页
         */ 
		$this->get_commodity(1,$where);
        $this->cache_data('all', $where);
        $this->cache->memcached->delete('filter');
        $this->cache->memcached->delete('query');
        $this->load->view ('commodity',$this->page_data);
	}
    
    
    
    /**
     * @获取商品列表
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  search_key:搜索关键字
     */
    public function get_commodity($offset,$where='',$page=0){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        //分页数量
        $page = $page ? $page : ($this->config->item('page_of_count'));
        $this->load->model('cowry_model','cowry');
        //商品列表
        $commodity_list=$this->cowry->get_user_cowry($where,$page,$page*($offset-1));
        //获取商品总数
        $commodity_count = count($this->cowry->get_user_cowry($where,0,0));
        //分页代码
        $page_html = $this->get_page($commodity_count, $offset, 'commodity_list_page');
        //debug($commodity_list);
        $this->page_data['commodity_list'] = $commodity_list;
        $this->page_data['page_html'] = $page_html;
        $this->page_data['page_type'] = 'commodity';
		//debug($this->page_data);
    }
    
    /**
     * @获取商品列表分页
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  search_key:搜索关键字
     */
    public function list_commodity(){
        $offset = $this->input->post('offset') ? $this->input->post('offset') : 1;//页码
        $type = $this->input->post('type');
        $where = $this->get_session_data($type);
        $this->get_commodity($offset,$where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    /**
     * @获取商品详情
     * @author zhoushuai
     */
    public function cowry(){
        $this->page_data['title']='2bi商家商品管理-商品详情';
        $this->page_data['current']='commodity';
        $cid=$this->input->get('cid');
        $uid=$this->input->get('uid');
        if(empty($cid)||empty($uid)){
            $this->errors='获取商品详情失败，请重新操作！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('cowry_model','cowry');
        $this->load->model('tag_model','tag');
        $cowryTag = $this->tag->get_cowry_tag($cid,$uid);
        $nameTags = array_column($cowryTag,'name');
        $idTags = array_column($cowryTag,'id_tag');
        $this->page_data['tagID'] = implode(' ',$idTags);
        $this->page_data['tagName'] = implode(' ',$nameTags);
        $this->page_data['tag']=$this->tag->get_tag();
        $this->page_data['cowry'] = $this->cowry->get_cowry_baseinfo($cid,$uid);
        $this->load->view ('cowry',$this->page_data);
    }
    
    /**
     * @删除商品
     * 删除宝贝需向该用户发送一条消息告知用户，并在客户端中消息模块中显示。
     * 内容：“你的宝贝涉及违规，已删除，如有疑问请向邻售客服反应”；
     */
    
    public function delcowry(){
        $cid=$this->input->post('cid');
        $uid=$this->input->post('uid');
        if(empty($cid)||empty($uid)){
            $this->errors='商品删除失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('admin_model','admin');
        $this->load->model('cowryowner_model', 'owner');
        //所有者 逻辑删除 只修改状态
        $where = 'id_cowry = ' . $cid . ' AND owner = ' . $uid;
        $result = $this->owner->update_owner(array('status' => 0), $where);
        if($result){
            /**
             * @删除商品向客户端发送消息。提醒商户
             */
            $this->sendmessage_to_client($uid,'sys','你的宝贝由于违反国家相关政策，已删除，如有疑问请向邻售客服反映！');
            //删除宝贝 动态信息
            $this->db->delete('bi_dynamic', array('object_id' => $cid));
            //删除动态宝贝的附件信息（图片）
            $this->db->delete('bi_dynamic_attachment', array('id_cowry' => $cid));
      
            $this->return_status(1,'删除成功！将宝贝改为无效');
        }
        $this->return_status(0,'删除失败！');
    }
    
    /**
     * @查询宝贝
     */
    public function query_cowry(){
        $key=$this->input->post('key');
        $type=$this->input->post('type');
        if(!isset($key)||empty($type)){
            $this->errors='查询失败！';
            $this->return_status(0, $this->errors);
        }
        switch($type){
            case 'username':
                $where = array('u.username'=>$key);
                break;
            case 'nickname':
                $where = array('u.nickname'=>$key);
                break;
            case 'description':
                $where = "ci.description like '%{$key}%'";
                break;
        }
        $this->get_commodity(1,$where);
        $this->cache_data('query', $where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    /**
      * 筛选宝贝 
      */
     public function filter(){
        $address=trim($this->input->post('address'));
        $end=$this->input->post('end');
        $begin=$this->input->post('begin');
        if(!empty($address)){
           $where = "d.address like '%{$address}%'";
        }
        if(!empty($begin)){
            if (empty($where))
            {
                $where  ="DATE_FORMAT(o.created,'%Y-%m-%d') >= '{$begin}'";
            }else{
                $where .=" AND DATE_FORMAT(o.created,'%Y-%m-%d') >= '{$begin}'";
            }
        }
        if(!empty($end)){
            if (empty($where))
            {
                $where  ="DATE_FORMAT(o.created,'%Y-%m-%d') <= '{$end}'";
            }else{
                $where .=" AND DATE_FORMAT(o.created,'%Y-%m-%d') <= '{$end}'";
            } 
        }
        $this->get_commodity(1,$where);
        $this->cache_data('filter', $where);
        echo $this->load->view ('lists',$this->page_data);
     }
    
    
    
    /**
     *@author zhoushuai
     *@param $receiver 消息接受者
     *@param type 消息类型
     *@param content 消息内容
     *@param objectId 对象id
     * http://192.168.0.9:8002/LinshouTcp.svc/sendmessage/{receiver}/{type}/{objectId}/{content}
     */
    private function sendmessage_to_client($receiver,$type,$content,$objectId=0){
        $tcp = _get_tcp_config();
        $content = urlencode($content);
        $url= 'http://'.$tcp['hostname'].':'.$tcp['port']."/LinshouTcp.svc/sendmessage/{$receiver}/{$type}/{$objectId}/{$content}";
        $return = $this->send_msg_to_client($url);
        //debug($return);
    }

    /*
     * zxx
     * 获取宝贝评论列表
     */
    function comment_list(){
        $offset = $this->input->post('offset') ? $this->input->post('offset') : 1;//页码
        $cid=$this->input->post('cid')?$this->input->post('cid'):$_GET['cid'];

        $this->get_comment($cid,$offset);
        if($this->input->post('page_type'))
            echo $this->load->view ('lists',$this->page_data);
        else
            echo $this->load->view ('comment',$this->page_data);
    }


    /*
     * zxx
     * 获取评论列表信息
     */
    private function get_comment($cid,$offset){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        //分页数量
        $page = $this->config->item('page_of_count');
        $this->load->model('cowrycomment_model','cowrycomment');
        $where = 'cc.id_cowry = ' . $cid;
        //评论列表
        $option['offset'] =$offset;
        $option['page'] = $page;
        $option['order'] = 'cc.created desc';
        $comment_list=$this->cowrycomment->get_cowry_comment($where,$option);
        //获取评论总数
        $option['offset'] =0;
        $comment_count = $this->cowrycomment->get_cowry_comment($where,$option,'count(cc.id_comment) as total');
        //分页代码
        $page_html = $this->get_page((int)($comment_count[0]['total']), $offset, 'comment_list_page');
        $this->page_data['comment_list'] = $comment_list;
        $this->page_data['page_html'] = $page_html;
        $this->page_data['page_type']='comment';
        $this->page_data['cid']=$cid;
        $this->page_data['offset']=$offset;
        $this->page_data['title']='零售后台管理-评论列表';
    }

    /*
     * zxx
     * 删除评论信息
     */
    function del_comment(){
        $commentid = $this->input->post('commentid');
        $this->load->model('cowrycomment_model','cowrycomment');
        $where = 'id_comment = ' . $commentid;
        $this->cowrycomment->del_cowry_comment($where);
    }

}

/* End of file commodity.php */
/* Location: ./admin/controllers/commodity.php */


























?>