<?php
/**
 * RSA 公钥 私钥加密 解密 尝试
 *
 * 
 */
namespace Common\Org;


use Base\ExceptionHandler;

class Rsa {
    private $_config;
    function __construct() {
        // require_once ('rsa.config.php');//配置文件
        $rsa_config = array(
                           'private_key' => C('RSA.RSA_PRIVATE_KEY'),
                           'public_key' => C('RSA.RSA_PUBLIC_KEY'),
                           );
        if (empty($rsa_config['private_key']) && empty($rsa_config['public_key'])) {
            throw new Exception('请配置公钥或私钥参数');
        }
        $this->_config = $rsa_config;
    }
    /**
     * 私钥加密
     * @param string $data 要加密的数据
     * @return string 加密后的字符串
     */
    public function privateKeyEncode($data) {
        $encrypted = '';
        $this->_needKey(2);
        $private_key = openssl_pkey_get_private($this->_config['private_key']);
        $fstr = array();
        $array_data = $this->_splitEncode($data);//把要加密的信息 base64 encode后 等长放入数组
        foreach ($array_data as $value) {//理论上是可以只加密数组中的第一个元素 其他的不加密 因为只要一个解密不出来 整体也就解密不出来 这里先全部加密
            openssl_private_encrypt($value, $encrypted, $private_key); //私钥加密
            $fstr[] = $encrypted;//对数组中每个加密
        }
        return base64_encode(serialize($fstr));//序列化后base64_encode
    }
    /**
     * 公钥加密
     * @param string $data 要加密的数据
     * @return string 加密后的字符串
     */
    public function publicKeyEncode($data) {
        $encrypted = '';
        $this->_needKey(1);
        $public_key = openssl_pkey_get_public($this->_config['public_key']);
        $fstr = array();
        $array_data = $this->_splitEncode($data);
        foreach ($array_data as $value) {
            openssl_public_encrypt($value, $encrypted, $public_key); //私钥加密
            $fstr[] = $encrypted;
        }
        return base64_encode(serialize($fstr));
    }
    /**
     * 用公钥解密私钥加密内容
     * @param string $data 要解密的数据
     * @return string 解密后的字符串
     */
    public function decodePrivateEncode($data) {
        $decrypted = '';
        $this->_needKey(1);
        $public_key = openssl_pkey_get_public($this->_config['public_key']);
        $array_data = $this->_toArray($data);//数据base64_decode 后 反序列化成数组
        $str = '';
        foreach ($array_data as $value){
               openssl_public_decrypt($value, $decrypted, $public_key); //私钥加密的内容通过公钥可用解密出来
               $str .= $decrypted;//对数组中的每个元素解密 并拼接
        }
        return base64_decode($str);//把拼接的数据base64_decode 解密还原
    }
    /**
     * 用私钥解密公钥加密内容 
     * @param string $data  要解密的数据
     * @return string 解密后的字符串
     */
    public function decodePublicEncode($data) {
        $decrypted = '';
        $this->_needKey(2);
        $private_key = openssl_pkey_get_private($this->_config['private_key']);
        $array_data = $this->_toArray($data);
        $str = '';
        foreach ($array_data as $value){
               openssl_private_decrypt($value, $decrypted, $private_key); //私钥解密
               $str .= $decrypted;
        }
        return base64_decode($str);
    }
    /**
     * 检查是否 含有所需配置文件
     * @param int 1 公钥 2 私钥
     * @return int 1
     * @throws Exception
     */
    private function _needKey($type) {
        switch ($type) {
            case 1:
                if (empty($this->_config['public_key'])) {
                    throw new Exception('请配置公钥');
                }
                break;
            case 2:
                if (empty($this->_config['private_key'])) {
                    throw new Exception('请配置私钥');
                }
                break;
        }
        return 1;
    }
    /**
     * 
     * @param type $data
     * @return type
     */
    private function _splitEncode($data) {
        $data = base64_encode($data); //加上base_64 encode  便于用于 分组
        $total_lenth = strlen($data);
        $per = 96;// 能整除2 和 3 RSA每次加密不能超过100个
        $dy = $total_lenth % $per;
        $total_block = $dy ? ($total_lenth / $per) : ($total_lenth / $per - 1);
        for ($i = 0; $i < $total_block; $i++) {
            $return[] = substr($data, $i * $per, $per);//把要加密的信息base64 后 按64长分组
        }
        return $return;
    }
    
    /**
     *公钥加密并用 base64 serialize 过的 data
     * @param type $data base64 serialize 过的 data
     */
    private  function _toArray($data){
        $data = base64_decode($data);
        $array_data = unserialize($data);
        if(!is_array($array_data)){
            throw new Exception('数据加密不符');
        }
        return $array_data;
    }
}






class Xcrypt{

    private $mcrypt;  
    private $key;  
    private $mode;  
    private $iv;  
    private $blocksize;

    /** 
     * 构造函数 
     * 
     * @param string 密钥 
     * @param string 模式 
     * @param string 向量（"off":不使用 / "auto":自动 / 其他:指定值，长度同密钥） 
     */  
    public function __construct($key, $mode = 'cbc', $iv = "off"){  
        switch (strlen($key)){  
        case 8:  
            $this->mcrypt = MCRYPT_DES;  
            break;  
        case 16:  
            $this->mcrypt = MCRYPT_RIJNDAEL_128;  
            break;  
        case 32:  
            $this->mcrypt = MCRYPT_RIJNDAEL_256;  
            break;  
        default:  
            die("Key size must be 8/16/32");  
        }  
        $this->key = $key;
        switch (strtolower($mode)){  
        case 'ofb':  
            $this->mode = MCRYPT_MODE_OFB;  
            if ($iv == 'off') die('OFB must give a IV'); //OFB必须有向量  
            break;  
        case 'cfb':  
            $this->mode = MCRYPT_MODE_CFB;  
            if ($iv == 'off') die('CFB must give a IV'); //CFB必须有向量  
            break;  
        case 'ecb':  
            $this->mode = MCRYPT_MODE_ECB;  
            $iv = 'off'; //ECB不需要向量  
            break;  
        case 'cbc':  
        default:  
            $this->mode = MCRYPT_MODE_CBC;  
        }
        switch (strtolower($iv)){  
        case "off":  
            $this->iv = null;  
            break;  
        case "auto":  
            $source = PHP_OS=='WINNT' ? MCRYPT_RAND : MCRYPT_DEV_RANDOM;  
            $this->iv = mcrypt_create_iv(mcrypt_get_block_size($this->mcrypt, $this->mode), $source);  
            break;  
        default:  
            $this->iv = $iv;  
        }  
    }  

    /** 
     * 获取向量值 
     * @param string 向量值编码（base64/hex/bin） 
     * @return string 向量值 
     */  
    public function getIV($code = 'base64'){  
        switch ($code){  
        case 'base64':  
            $ret = base64_encode($this->iv);  
            break;  
        case 'hex':  
            $ret = bin2hex($this->iv);  
            break;  
        case 'bin':  
        default:  
            $ret = $this->iv;  
        }  
        return $ret;  
    }  

    /** 
     * 加密 
     * @param string 明文 
     * @param string 密文编码（base64/hex/bin） 
     * @return string 密文 
     */  
    public function encrypt($str, $code = 'base64'){  
        if ($this->mcrypt == MCRYPT_DES) $str = $this->_pkcs5Pad($str);  
  
        if (isset($this->iv)) {  
            $result = mcrypt_encrypt($this->mcrypt, $this->key, $str, $this->mode, $this->iv);    
        } else {  
            @$result = mcrypt_encrypt($this->mcrypt, $this->key, $str, $this->mode);    
        }
        switch ($code){  
        case 'base64':  
            $ret = base64_encode($result);  
            break;  
        case 'hex':  
            $ret = bin2hex($result);  
            break;  
        case 'bin':  
        default:  
            $ret = $result;  
        }
        return $ret;
    }  
  
    /** 
     * 解密  
     * @param string 密文 
     * @param string 密文编码（base64/hex/bin） 
     * @return string 明文 
     */  
    public function decrypt($str, $code = "base64"){      
        $ret = false;
        switch ($code){  
        case 'base64':  
            $str = base64_decode($str);  
            break;  
        case 'hex':  
            $str = $this->_hex2bin($str);  
            break;  
        case 'bin':  
        default:  
        }
        if ($str !== false){  
            if (isset($this->iv)) {  
                $ret = mcrypt_decrypt($this->mcrypt, $this->key, $str, $this->mode, $this->iv);    
            } else {  
                @$ret = mcrypt_decrypt($this->mcrypt, $this->key, $str, $this->mode);    
            }  
            if ($this->mcrypt == MCRYPT_DES) $ret = $this->_pkcs5Unpad($ret);  
            $ret = trim($ret);  
        }
        return $ret;   
    }   

    private function _pkcs5Pad($text){  
        $this->blocksize = mcrypt_get_block_size($this->mcrypt, $this->mode);    
        $pad = $this->blocksize - (strlen($text) % $this->blocksize);  
        return $text . str_repeat(chr($pad), $pad);  
    }

    private function _pkcs5Unpad($text){  
        $pad = ord($text{strlen($text) - 1});  
        if ($pad > strlen($text)) return false;  
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;  
        $ret = substr($text, 0, -1 * $pad);  
        return $ret;  
    }  

    private function _hex2bin($hex = false){  
        $ret = $hex !== false && preg_match('/^[0-9a-fA-F]+$/i', $hex) ? pack("H*", $hex) : false;      
        return $ret;  
    }
}