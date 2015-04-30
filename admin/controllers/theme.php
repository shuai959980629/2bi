<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 *@后台管理员专题管理
 *@version v-2.0
 *@author zhoushuai
 *@copyright 2014-11-4
 */
class Theme extends Admin_Controller{

	
	
    public function __construct(){
        parent::__construct();
    }
    
    public function index() {
	    $this->page_data['title']='邻售后台-新增专题活动列表';
        $this->page_data['current']='theme';
        $where = '';
        $this->get_theme_list(1,'',8);
        $this->cache_data('all', $where);
        $this->cache->memcached->delete('query');
        $this->load->view ('theme_list',$this->page_data);
	}
    
    /**
     * @获取专题活动列表
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    public function get_theme_list($offset,$where,$page=0){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        //每页显示数量
        $page = $page ? $page:($this->config->item('page_of_count'));
        $this->load->model('theme_model','theme');
        //专题活动列表
        $theme_list=$this->theme->get_theme_list($where,$page,$page*($offset-1));
        //获取专题活动总数
        $theme_count = count($this->theme->get_theme_list($where,0,0));
        //分页代码
        $page_html = $this->get_page($theme_count, $offset, 'theme_list_page','method',$page);
        $this->page_data['theme_list'] = $theme_list;
        $this->page_data['page_html'] = $page_html;
        $this->page_data['page_type']='theme_list';
    }
    
    
    
    /**
     * @获取专题活动列表分页
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    public function theme_list(){
        $offset = $this->input->post('offset') ? $this->input->post('offset') : 1;//页码
        $type = $this->input->post('type');
        $where = $this->get_session_data($type);
        $this->get_theme_list($offset,$where,8);
        echo $this->load->view ('lists',$this->page_data);
    }
    
    
    /**
     * @查询专题活动
     */
     public function query_theme(){
        $name=$this->input->post('name');
        if(!isset($name)){
            $this->errors='查询失败！';
            $this->return_status(0, $this->errors);
        }
        $where = "name like '%{$name}%'";
        $this->get_theme_list(1,$where,8);
        $this->cache_data('query', $where);
        echo $this->load->view ('lists',$this->page_data);
     }
    
    
    /**
     * @新增专题活动内容
     */
    public function add(){
        $this->page_data['title']='邻售后台-新增专题活动内容';
        $this->page_data['current']='theme';
        $type = trim($this->input->get('type'));
        $this->init_theme($type);
        $this->load->view ('add_theme',$this->page_data);
    }
    
    private function init_theme($type){
        switch($type){
            case 'edit':
                $this->initEdt();                
                break;
            default:
                $this->page_data['method']='add';
                break;
        }
    }
	
    /**
     * @初始化页面信息
     */
    private function initEdt(){
        $this->load->model('theme_model','theme');
        $id_theme = intval($this->input->get('tid'));
        $actvity=$this->theme->get_theme_by_id($id_theme);
        $theme  = array(
            'id_theme'=>$actvity['id_theme'],
            'name'=>$actvity['name'],
            'logo' =>end(explode('/',$actvity['logo'])),
            'valid_begin'=>date('Y-m-d',strtotime($actvity['valid_begin'])),
            'valid_end'=>date('Y-m-d',strtotime($actvity['valid_end'])),
            'address'=>$actvity['address'],
            'type'=>$actvity['type'],
            'cowry'=>'',
            'link'=>'',
            'rule'=>$actvity['rule'],
            'join'=>$actvity['join'],
            'order'=>$actvity['orders']
        );
        if($actvity['type']=='normal'){
            $theme['cowry']=$actvity['content'];
        }else{
            $theme['link']=$actvity['content'];
        }
        foreach($theme as $key=>$val){
            $this->page_data[$key]=$val;
            if($key=='logo' && !empty($val)){
                $path = ATTACH_PATH.'theme/'. $val;
                if(!file_exists($path)){
                    $this->page_data[$key]='';
                }
            }
        } 
       $this->page_data['method']='edt';       
    }
    
    /**
     * @新增专题活动内容
     */
    public function add_theme(){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        $name=trim($this->input->post('name'));
        $logo = trim($this->input->post('logo'));
        $valid_begin = trim($this->input->post('valid_begin'));
        $valid_end = trim($this->input->post('valid_end'));
        $address=trim($this->input->post('address'));
        $type =trim($this->input->post('type'));
        $orders=trim($this->input->post('order'));
        $join = intval($this->input->post('join'));
        $rule =trim($this->input->post('rule'));
        if(empty($logo)|| empty($name)|| empty($valid_begin)||empty($address)||empty($valid_end)||empty($type)||empty($orders)){
            $this->errors='数据不完整。添加失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('theme_model','theme');
        //第一步：验证专题名称是否已经存在
        $where1 = array('name'=>$name);
        $isExt = $this->theme->get_theme($where1);
        if($isExt){
            $this->return_status(0,'专题活动名称已经存在，请重新填写！');
            exit();
        }
        //第二部：获取地址经纬度坐标
        $addArray = $this->get_lat_lng($address);
        if($addArray['status']!=0){
            $this->errors='获取地址信息失败。专题活动添加失败！';
            $this->return_status(0, $this->errors);
        }       
        //第三步：组装数据。添加到数据库
        $theme = array(
            'name'=>$name,
            'type'=>$type,
            'logo'=>'/attachment/theme/'.$logo,
            'rule'=>$rule,
            'join'=>$join,
            'address'=>$address,
            'latitude'=>$addArray['result']['location']['lat'],
            'longitude'=>$addArray['result']['location']['lng'],
            'orders'=>$orders,
            'valid_begin'=>$valid_begin,
            'valid_end'=>$valid_end
        );
		if($type=='web'){
			$content = trim($this->input->post('content'));
			if(empty($content)){
				$this->errors='网页连接地址不能为空！';
				$this->return_status(0, $this->errors);
			}
			$theme['content'] = $content;
		}
		$id_theme=$this->theme->insert_theme($theme);
        if($id_theme){
            $this->return_status(1,'专题活动添加成功！');
        }else{
            $this->errors='专题活动添加失败！';
            $this->return_status(0, $this->errors);
        }
    }
    /**
     * @修改专题活动内容
     */
    public function edt_theme(){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        $name=trim($this->input->post('name'));
        $logo = trim($this->input->post('logo'));
        $valid_begin = trim($this->input->post('valid_begin'));
        $valid_end = trim($this->input->post('valid_end'));
        $address=trim($this->input->post('address'));
        $type =trim($this->input->post('type'));
        $orders=trim($this->input->post('order'));
        $id_theme = intval($this->input->post('id_theme'));
        $method = trim($this->input->post('method'));
        $join = intval($this->input->post('join'));
        $rule =trim($this->input->post('rule'));
        if($method!='edt'){
            $this->return_status(0,'数据出错。修改失败！');
        }
        if(empty($id_theme)|| empty($logo)|| empty($name)|| empty($valid_begin)||empty($address)||empty($valid_end)||empty($type)||empty($orders)){
            $this->errors='数据不完整。修改失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('theme_model','theme');
        //第一步：验证专题名称是否已经存在
        $where1 = array('name'=>$name,'id_theme !='=>$id_theme);
        $isExt = $this->theme->get_theme($where1);
        if($isExt){
            $this->return_status(0,'专题活动名称已经存在，请重新填写！');
            exit();
        }
        //第二部：获取地址经纬度坐标
        $addArray = $this->get_lat_lng($address);
        if($addArray['status']!=0){
            $this->errors='获取地址信息失败。专题活动修改失败！';
            $this->return_status(0, $this->errors);
        }       
        //第三步：组装数据。添加到数据库
        $theme = array(
            'name'=>$name,
            'type'=>$type,
            'logo'=>'/attachment/theme/'.$logo,
            'rule'=>$rule,
            'join'=>$join,
            'address'=>$address,
            'latitude'=>$addArray['result']['location']['lat'],
            'longitude'=>$addArray['result']['location']['lng'],
            'orders'=>$orders,
            'valid_begin'=>$valid_begin,
            'valid_end'=>$valid_end
        );
		//第四步：获取原来专题的信息，
		$where = array('id_theme'=>$id_theme);
		$actvity=$this->theme->get_theme_by_id($id_theme);
		if($type=='web'){
			$content = trim($this->input->post('content'));
			if(empty($content)){
				$this->errors='网页连接地址不能为空！';
				$this->return_status(0, $this->errors);
			}
			if($actvity['type']=='normal'){
				//删除专题以前添加的宝贝
				$this->theme->delete_theme_cowry($where);
			}
			$theme['content'] = $content;
		}elseif($type=='normal'){
			if($actvity['type']=='web'){
				$theme['content']='';
			}
		}
		//第五步：修改专题信息
        $res=$this->theme->modify_theme($theme,$where);
        if($res){
            $this->return_status(1,'专题活动修改成功！');
        }else{
            $this->errors='专题活动修改失败！';
            $this->return_status(0, $this->errors);
        }
    }
    
    
	
    /**
     * @新增专题宝贝
     */
    public function save_theme_cowry(){
        $id_theme=$this->input->post('id_theme');
        $data=$this->input->post('data');
		if(!empty($data)&&!empty($id_theme)){
			$cowry = json_decode($data,true);//新增专题宝贝id
			if(!empty($cowry)){
				$addCowry = array();
				$this->load->model('theme_model','theme');
				foreach($cowry as $key=>$val){
					$addCowry[] = array('id_theme'=>$id_theme,'id_cowry'=>$val,'status'=>1,'created'=>date('Y-m-d H:i:s', time()));
				}
				$res = $this->theme->insert_batch_theme_cowry($addCowry);
				if($res){
					$this->return_status(1,'新增专题宝贝，保存成功！');
				}
			}
		}
        $this->return_status(0,'页新增专题宝贝，保存失败！');
    }
	
	
	
    /**
     * @专题宝贝审核，专题宝贝列表
     */
    public function thcowry(){
        $id_theme = intval($this->input->get('tid'));
        if(empty($id_theme)){
            show_404();
        }
        $this->page_data['title']='邻售后台-专题宝贝列表';
        $this->page_data['current']='theme';
		$this->page_data['id_theme']=$id_theme;
        $where= array('t.id_theme'=>$id_theme);
        $this->get_theme_cowry_list(1,$where);
        $this->cache_data('all', $where);
        $this->cache->memcached->delete('query');
        $this->load->view ('theme_cowry_list',$this->page_data);
     }
    
    
    
    /**
     * @获取专题宝贝列表
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    public function get_theme_cowry_list($offset,$where,$page=8){
        if(!$this->users['id_admin']){
            $this->ini_user();
        }
        //每页显示数量
        $page = $page ? $page:($this->config->item('page_of_count'));
        $this->load->model('theme_model','theme');
        //专题宝贝
        $theme_cowry_list=$this->theme->get_theme_cowry_list($where,$page,$page*($offset-1));
        //debug($theme_cowry_list);
        //exit;
        //获取专题宝贝总数
        $theme_cowry_count = count($this->theme->get_theme_cowry_list($where,0,0));
        //分页代码
        $page_html = $this->get_page($theme_cowry_count, $offset, 'theme_cowry_list_page','method',$page);
        $this->page_data['theme_cowry_list'] = $theme_cowry_list;
        $this->page_data['page_html'] = $page_html;
        $this->page_data['page_type']='theme_cowry_list';
    }
    
    
    
    /**
     * @获取专题宝贝列表分页
     * @author zhoushuai
     * @param int  offset ：页码
     * @param int  page ：条数
     * @param string  where:查询条件
     */
    public function theme_cowry_list(){
        $offset = $this->input->post('offset') ? $this->input->post('offset') : 1;//页码
        $type = $this->input->post('type');
        $where = $this->get_session_data($type);
        $this->get_theme_cowry_list($offset,$where);
        echo $this->load->view ('lists',$this->page_data);
    }
    
	/**
	 *@查询专题宝贝
	 */
    public function query_theme_cowry(){
		$status = intval($this->input->post('status'));
		$id_theme = intval($this->input->post('id_theme'));
        if(empty($id_theme)){
            echo '页面出错，请刷新！';
        }
        $where= array('t.id_theme'=>$id_theme);
		if(!isset($status)){
            echo '数据丢失，查询失败！';
        }
		$where['tc.status']=$status;
		$this->get_theme_cowry_list(1,$where);
        $this->cache_data('query', $where);
        echo $this->load->view ('lists',$this->page_data);
	}
    
    /**
	 *@拒绝申请。专题宝贝
	 */    
	public function decline(){
		$id_theme_cowry = intval($this->input->post('tcid'));
        if(empty($id_theme_cowry)){
            $this->errors='页面出错，请刷新！';
            $this->return_status(0, $this->errors);
        }
		$this->load->model('theme_model','theme');
		$data = array('status'=>2);
		$where = array('id_theme_cowry'=>$id_theme_cowry);
		$res = $this->theme->modify_theme_cowry($data,$where);
		if($res){
			$this->return_status(1,'专题活动宝贝内容修改成功！');
		}
		$this->return_status(0,'专题活动宝贝内容修改失败！');
	}
	
	
	/**
	 *@同意申请，审核通过。专题宝贝
	 */    
	public function permit(){
		$id_theme_cowry = intval($this->input->post('tcid'));
        if(empty($id_theme_cowry)){
            $this->errors='页面出错，请刷新！';
            $this->return_status(0, $this->errors);
        }
		$this->load->model('theme_model','theme');
		$data = array('status'=>1);
		$where = array('id_theme_cowry'=>$id_theme_cowry);
		$res = $this->theme->modify_theme_cowry($data,$where);
		if($res){
			$this->return_status(1,'专题活动宝贝内容修改成功！');
		}
		$this->return_status(0,'专题活动宝贝内容修改失败！');
	}
	
    
    /**
     * 专题管理
     */
    public function manage(){
        $type=$this->input->post('type');
        $data=$this->input->post('data');
        if(empty($type)||empty($data)){
            $this->errors='操作失败！';
            $this->return_status(0, $this->errors);
        }
        $this->load->model('theme_model','theme');
        if($type=='close'){
            //关闭
            $id_theme = intval($data);
            $dta= array('status'=>0);
            $where = array('id_theme'=>$id_theme);
            $res = $this->theme->modify_theme($dta,$where);
            if($res){
                $this->return_status(1,'操作成功！');
            }
        }elseif($type=='open'){
            //开启
            $id_theme = intval($data);
            $dta= array('status'=>1);
            $where = array('id_theme'=>$id_theme);
            $res = $this->theme->modify_theme($dta,$where);
            if($res){
                $this->return_status(1,'操作成功！');
            }
        }elseif($type=='del'){
            $id_theme = intval($data);
            $where = array('id_theme'=>$id_theme);
            $result = $this->theme->get_theme($where);
            if(!$result){
                $this->return_status(1,'活动已经被删除，请勿重复操作！');
            }
            $logo = $result[0]['logo'];
            $path = DOCUMENT_ROOT.$logo;
            if(file_exists($path)){
                unlink($path);
            }
            $res1 = $this->theme->delete_theme($where);
            if($res1){
                $res2 = $this->theme->delete_theme_cowry($where);
                if($res2){
                    $this->return_status(1,'操作成功！');
                }
            }
        }
        $this->return_status(0,'操作失败！');
    }
    
    /**
	 *@百度地图。地址坐标
	 */
    private function get_lat_lng($address){
        $cacert = ROOT_PATH. 'attachment/key/cacert.pem';
        $url = 'http://api.map.baidu.com/geocoder/v2/?address='.$address.'&output=json&ak=1edcc05cdfc261ed49e9b2a7c33554fb';
        $result = getHttpResponseGET($url,$cacert);
        $addArray = json_decode($result,true);
        return $addArray; 
    }
    
      
}
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 ?>