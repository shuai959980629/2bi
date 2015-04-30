<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
/**
 * @开发测试
 * @描述文件的功能
 * @author zhoushuai
 * @date 2013-10-24 16:51
 */
class Home extends CI_Controller {

	//104.072753,30.649054
	protected $curl_uri ;
	protected $token ;
	protected $version;
    protected $platform;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library ( 'input' );
        //$this->token = '752290181cdeaef0ce8fbdf3611af3cd4e921098737accedd61f8b08c1e02516f138033d9bcc6197ac74a69809f09ff3625badeda7dd1eddd576de446a074369e0403c0ed407c123907e24d45243581717f759fc0efe39bc589414a153d447aa9e690813118c5f98e06a3568500067794da3528e228ed2300f7cd0dc752f70ad';//登陆的证书 
    } 
	/**
	 * 这是一个模板文件，可以直接拷贝进行修改
	 */
	public function index() {
        if(ENVIRONMENT=='production'){
            header("Location: http://www.linshou.com/");
        }else{
            $data ['url_action'] = '/index.php/home/curl_post';
            $this->load->view ( 'test', $data );
        }
	}
    /**
     * 图片上传 本地；环境测开发
     * http://www.2bi.com/index.php/home/upload
     */ 
    public function upload(){
        $data ['url_action'] = '/publicity/upload_attachment';
		$this->load->view ( 'upload', $data );
    }
    
    
	public function curl_post() {
        $this->platform =$this->input->post ( 'clients' );
        $this->version = $this->input->post('version');
        $this->token = $this->input->post('token');
        $url = $this->input->post('url');
        $this->curl_uri ='http://' . $_SERVER['HTTP_HOST'].'/'.$url;
		if (! in_array ( $this->platform, array (
				'android',
				'ios' 
		) )) {
			header ( 'Content-Type:text/html;charset=utf-8' );
			exit ( '客户端错误' );
		}
		
		// 测试用的浏览器信息
		$browsers = array (
				"web" => array (
						"user_agent" => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 (.NET CLR 3.5.30729)",
						"language" => "en-us,en;q=0.5" 
				),
				"iphone" => array (
						"user_agent" => "Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A537a Safari/419.3",
						"language" => "en" 
				),
				"android" => array (
						"user_agent" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; GTB6; .NET CLR 2.0.50727)",
						"language" => "fr,fr-FR;q=0.5" 
				) 
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->curl_uri);
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
		"User-Agent: {$browsers['iphone']['user_agent']}",
		"Accept-Language: {$browsers['iphone']['language']}",
		//"Content-Type:application/x-www-form-urlencoded",
		"Token:{$this->token}",
        "Version:{$this->version}",
        "From:{$this->platform}",
		"Bb-version:1.0",
		"Planform:web"
		) );
		curl_setopt ( $ch, CURLOPT_NOBODY, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt ( $ch, CURLOPT_HEADER, 1 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		// 我们在POST数据哦！
		curl_setopt($ch, CURLOPT_POST, 1);
		// 把post的变量加上
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('params'=>$this->input->post('params')));
		$output = curl_exec($ch);
		curl_close($ch);
		if(FALSE === $output){
			echo "cURL Error: " . curl_error($ch);
			exit;
		}
		echo '<div style="padding-left:100px;padding-top:40px"><hr />';
		echo '<a href="/">返回首页</a>';
		echo '<hr />';
        echo '<br />';
        echo '请求平台：'.$this->platform.'<br/>';
        echo '<br />';
		echo '客户端版本Version：'.$this->version."<br />";
		echo '<br />';
		echo '请求接口：'.$this->curl_uri."<br />";
		echo '<br />';
		echo '请求Token：'.$this->token."<br />";
        echo '<hr />';
		echo '<br />';
		echo '请求参数(json)：'.$this->input->post('params')."<br />";
		echo '<br />';
		echo '请求参数(array):'."<br />";
		$this->print_f(json_decode($this->input->post('params'),TRUE));
		echo '<br />';
		echo '返回数据(json):'.$output."<br />";
		echo '<br />';
		echo '返回数据(array):'."<br />";
		$this->print_f(json_decode($output,TRUE));
		echo '</div>';
		
		exit;	
		
	}
	private function print_f($data) {
		header ( 'Content-Type:text/html;charset=utf-8' );
		echo '<pre>';
		print_r ( $data );
	}
	
}

/* End of file home.php */
/* Location: ./service/controllers/home.php */