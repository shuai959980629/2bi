<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* DES 证书的加密盒解密
* @author rjy
* 使用方法
* @param $key 密钥(长度8), $iv 偏移量
* $crypt = new Class_Des($key, $iv);
* $str = $crypt->encrypt('明文');
* $str = $crypt->decrypt('密文');
*/
final class Des
{
	
    private $key;
    private $iv;//偏移量
    
    
    public function __construct($params){
    	
    	$this->Des($params);
    	
    }
    
    private function Des($params) {
    	
        $this->key = $params['key'];
        if(!isset($params['iv'])) {
            $this->iv = $params['key']; //默认以$key 作为 iv
        } else{
            $this->iv = $params['iv']; //mcrypt_create_iv ( mcrypt_get_block_size (MCRYPT_DES, MCRYPT_MODE_CBC), MCRYPT_DEV_RANDOM );
        }
        
    }
    
    public function encrypt($str) {
    	
        //加密，返回大写十六进制字符串
        $size= mcrypt_get_block_size ( MCRYPT_DES, MCRYPT_MODE_CBC );
        $str= $this->pkcs5Pad ( $str, $size);
        return strtoupper( bin2hex( mcrypt_cbc(MCRYPT_DES, $this->key, $str, MCRYPT_ENCRYPT, $this->iv ) ) );
        
    }
    
    public function decrypt($str) {
    	
        //解密
        $strBin= $this->hex2bin( strtolower( $str) );
        $str= mcrypt_cbc( MCRYPT_DES, $this->key, $strBin, MCRYPT_DECRYPT, $this->iv );
        $str= $this->pkcs5Unpad( $str);
        return $str;
        
    }
    
    public function hex2bin($hexData) {
    	
        $binData= "";
        for($i= 0; $i< strlen( $hexData); $i+= 2) {
            $binData.= chr( hexdec ( substr( $hexData, $i, 2 ) ) );
        }
        return $binData;
        
    }
    
    public function pkcs5Pad($text, $blocksize) {
    	
        $pad= $blocksize- (strlen( $text) % $blocksize);
        return $text. str_repeat( chr( $pad), $pad);
        
    }
    
    public function pkcs5Unpad($text) {
    	
        $pad= ord ( $text{strlen( $text) - 1} );
        if($pad> strlen( $text))
            return false;
        if(strspn( $text, chr( $pad), strlen( $text) - $pad) != $pad)
            return false;
        return substr( $text, 0, - 1 * $pad);
        
    }
    
}

/* End of file des.php */
/* Location: ./service/controllers/des.php */