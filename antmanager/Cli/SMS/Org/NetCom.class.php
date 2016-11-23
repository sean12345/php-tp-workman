<?php
namespace SMS\Org;


/**
* 网站常用功能类
*@author爱民
*/
class NetCom 
{	
	/**
  * url 为服务的url地址
  * query 为请求串
  */
  public static function sock_post($url,$query){
      $data = "";
      $info=parse_url($url);
      $fp=fsockopen($info["host"],80,$errno,$errstr,30);
      if(!$fp){
          return $data;
      }
      $head="POST ".$info['path']." HTTP/1.0\r\n";
      $head.="Host: ".$info['host']."\r\n";
      $head.="Referer: http://".$info['host'].$info['path']."\r\n";
      $head.="Content-type: application/x-www-form-urlencoded\r\n";
      $head.="Content-Length: ".strlen(trim($query))."\r\n";
      $head.="\r\n";
      $head.=trim($query);
      $write=fputs($fp,$head);
      $header = "";
      while ($str = trim(fgets($fp,4096))) {
          $header.=$str;
      }
      while (!feof($fp)) {
          $data .= fgets($fp,4096);
      }
      return $data;
  }

  function postSMS($url, $data='')
  {
    $row = parse_url($url);
    $host = $row['host'];
    $port = $row['port'] ? $row['port']:80;
    $file = $row['path'];
    while (list($k,$v) = each($data)) 
    {
      $post .= rawurlencode($k)."=".rawurlencode($v)."&"; //转URL标准码
    }
    $post = substr( $post , 0 , -1 );
    $len = strlen($post);
    $fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
    if (!$fp) {
      return "$errstr ($errno)\n";
    } else {
      $receive = '';
      $out = "POST $file HTTP/1.0\r\n";
      $out .= "Host: $host\r\n";
      $out .= "Content-type: application/x-www-form-urlencoded\r\n";
      $out .= "Connection: Close\r\n";
      $out .= "Content-Length: $len\r\n\r\n";
      $out .= $post;    
      fwrite($fp, $out);
      while (!feof($fp)) {
        $receive .= fgets($fp, 128);
      }
      fclose($fp);
      $receive = explode("\r\n\r\n",$receive);
      unset($receive[0]);
      return implode("",$receive);
    }
  }

}

?>