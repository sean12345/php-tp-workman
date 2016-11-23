##  [Ant-Nest 蚁巢服务平台](admin/main)

---------
###### 
> |接口文档|
|:-----  |
||[SMS短信服务接口文档](sms/doc#1)|
||[用户中心服务接口文档](ucenter/doc#1)|
||[RSA秘钥获服务取接口文档](transfer/doc#1)|
||[OSS图片上传服务取接口文档](transfer/doc#2)|
||[JPUSH消息推送服务接口文档](auctionsub/doc#1)|

---------

#### 接口调用类
##### Request.clsss.php
```
<?php
/**
 * 客户端接口请求类
 *
 * 请妥善保存app_key和secret_key, 以免数据泄露
 * 
 * @param string $app_key
 * @param string $secret_key
 */
namespace Common\Org;

use \Common\Org\Xcrypt;

class Request
{
    private $_app_key = '';
    private $_access_token = '';

    public function __construct($app_key, $secret_key)
    {
        $m = new Xcrypt($secret_key, 'ecb', 'auto');
        $time_now = time();
        $access_key = $app_key . '_' . $secret_key . '_' . $time_now;
        $this->_app_key = $app_key;
        $this->_access_token = $m->encrypt($access_key, 'base64');
    }

    /**
     * 请求接口返回内容
     * 
     * @param  string $url [请求的URL地址]
     * @param  string $header [header权限校验参数]
     * @param  json $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    public function juhecurl($url, $params='', $ispost=0){
        $httpInfo = array();
        $ch = curl_init();
        $header = array(
            "content-type: application/x-www-form-urlencoded; charset=UTF-8",
            'appkey:' . $this->_app_key,
            'token:' . $this->_access_token,
        );
        curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt ($ch, CURLOPT_COOKIE, 'XDEBUG_SESSION=1');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $params = json_decode($params, true);
        $data = http_build_query($params);
        /*备注： 如果后期需要对http通讯过程中的数据做加密传输，则打开以下代码*/
        // $m = new \Common\Org\Xcrypt($key, 'ecb', 'auto');
        // $data = $m->encrypt($a);
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $data );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            $strUrl = !empty($data) ? $url.'?'.$data : $url;
            curl_setopt( $ch , CURLOPT_URL , $strUrl);
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            throw new Exception("AN接口访问异常！");
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }
}
```

##### Xcrypt.clsss.php
```
<?php
/** 
 * DES对称加密算法类 
 * 
 * 支持密钥：64/128/256 bit（字节长度8/16/32） 
 * 支持算法：DES/AES（根据密钥长度自动匹配使用：DES:64bit AES:128/256bit） 
 * 支持模式：CBC/ECB/OFB/CFB 
 * 密文编码：base64字符串/十六进制字符串/二进制字符串流 
 * 填充方式: PKCS5Padding（DES） 
 * 
 */  
namespace Common\Org;

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
```