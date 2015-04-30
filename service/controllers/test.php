<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 *
 *
 * 测试模型
 *
 * @author jxy
 *         @date 2013-10-24 16:51
 */
class Test extends Bibi_Controller {
	
	/**
	 * 这是一个模板文件，可以直接拷贝进行修改
	 */
	public function index() {
		
		// phpinfo();exit;
		// todo
		$this->load->library ( 'mongo_db' );
		// 写入数据
		// $this->mongo_db->insert('cert',array('cert_encode'=>'752290181cdeaef0ce8fbdf3611af3cd4e921098737accedd61f8b08c1e02516f138033d9bcc6197ac74a69809f09ff3625badeda7dd1eddd576de446a074369e0403c0ed407c123907e24d45243581717f759fc0efe39bc589414a153d447aa9e690813118c5f98e06a3568500067794da3528e228ed2300f7cd0dc752f70ad','time'=>time()));
		// 读取数据
		// $test_data = $this->mongo_db->get('cert');
		$test_data = $this->mongo_db->get_where ( 'cert', array (
				'cert_encode' => '752290181cdeaef0ce8fbdf3611af3cd4e921098737accedd61f8b08c1e02516f138033d9bcc6197ac74a69809f09ff3625badeda7dd1eddd576de446a074369e0403c0ed407c123907e24d45243581717f759fc0efe39bc589414a153d447aa9e690813118c5f98e06a3568500067794da3528e228ed2300f7cd0dc752f70ad' 
		) );
		debug ( $test_data );
		// $mongo = new Mongo('mongodb://xrenwu:123456@192.168.0.6:27017/2bi');
		// debug($mongo);
	}
	public function test_redis() {
		$this->load->driver ( 'cache', array (
				'adapter' => 'redis' 
		) );
		
		if (! $soho = $this->cache->get ( 'soho' )) {
			echo 'Saving to the cache!<br />';
			$soho = 'www.sohocn.net';
			// Save into the cache for 5 minutes
			$this->cache->save ( 'soho', $soho, 300 );
		}
		
		echo $soho;
	}
	public function test_py() {
		
		$this->load->library ( 'Chinese' );
		
		$result = $this->chinese->get_first_word( '士大夫' );
		debug ( $result );
		
	}
	public function test_procedure() {
		
		
		 $this->load->model('bb_info_model','bb_info');
		//104.07214,30.663443
		/*$result = $this->bb_info->get_near_bblist(104.07214,30.663443,1,10,1); */
	}
	
	
	//根据经纬度计算距离 其中A($lat1,$lng1)、B($lat2,$lng2)
	public static function getDistance()
	{
		$lat1 = 30.663333;
		$lng1 = 104.072277;
		//,
		$lat2 = 30.649054;
		$lng2 = 104.072753;
		
		//地球半径
		$R = 6378137;
	
		//将角度转为狐度
		$radLat1 = deg2rad($lat1);
		$radLat2 = deg2rad($lat2);
		$radLng1 = deg2rad($lng1);
		$radLng2 = deg2rad($lng2);
	
		//结果
		$s = acos(cos($radLat1)*cos($radLat2)*cos($radLng1-$radLng2)+sin($radLat1)*sin($radLat2))*$R;
	
		//精度
		$s = round($s* 10000)/10000;
	
		echo  round($s);
	}
	
	
	public function test_log(){
		
		global $starttime;
		$replce = array(
			date('Y-m-d H:i:s'),
			'android',
			'/index.php/bibi/get_bblist',
			'请求参数json',
			'请求参数array',
			'返回json',
			'返回array'
		);
		
		$requst = '{"number":10,"desc":"\u63cf\u8ff0\u4fe1\u606f","cowimg":["\/favicon\/1223.jpg","\/favicon\/5666.jpg"]}';
		
		$planform = 'android';
		$uri = $_SERVER['REQUEST_URI'];
		$return = '{"status":1,"data":["\u4f60\u4eec\u5728\u54ea\u91cc","\u665a\u4e0a\u5403\u4ec0\u4e48"],"msg":null}';
		
		$args = implode(',', $replce);
		$log = $this->lang->line('debug');
		//debug($args)
		$log = sprintf($log,date('Y-m-d H:i:s'),$planform,microtime(TRUE)-$starttime,$uri,$requst,var_export(json_decode($requst,TRUE),TRUE),$return,var_export(json_decode($return,TRUE),TRUE));
		debug($log);
		debug($log);
		
	}
	
	
	
	public function test_des(){
		
		$params = array('key'=>$this->config->item('token_key'));
		$this->load->library('des',$params);
		$result = $this->des->encrypt('abcd');
		
		debug($result);
	}
	
	
}

/* End of file Test.php */
/* Location: ./service/controllers/test.php */