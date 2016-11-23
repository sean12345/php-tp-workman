<?php
use Think\Model;

define(SQLITE_COLUMN_NAME_KEY, 'name');	//sqlite列名键
define(MYSQL_COLUMN_NAME_KEY, 'column_name');	//mysql列名键

function timeNow()
{
    return date('Y-m-d H:i:s', time());
}

/**
 * 验证手机号
 * @param type $phone
 * @return type
 */
function validatePhone($phone)
{
    if (!is_numeric($phone)) {
        return false;
    }
    return strlen($phone) == 11 && preg_match("/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/", $phone);
}

/**
 * 验证手机验证码
 * $param type int $auth_code 手机验证码
 */
function validateAuthCode($auth_code)
{
    if (!is_numeric($auth_code)) {
        return false;
    }
    return strlen($auth_code) == 6 && preg_match("/^[0-9]{6}$/", $auth_code);
}

function fileTail($file, $num){  
    $lines = array();
    if (file_exists($file)) {
        $fp = fopen($file,"r");
        $pos = -2;
        $eof = "";
        $head = false; //当总行数小于Num时，判断是否到第一行了  
        while($num>0){
            while($eof != "\n"){
                if(fseek($fp, $pos, SEEK_END)==0){ //fseek成功返回0，失败返回-1
                    $eof = fgetc($fp);
                    $pos--;
                }else{ //当到达第一行，行首时，设置$pos失败
                    fseek($fp,0,SEEK_SET);
                    $head = true; //到达文件头部，开关打开  
                    break;  
                }
            }  
            array_unshift($lines,fgets($fp));  
            if($head){ break; } //这一句，只能放上一句后，因为到文件头后，把第一行读取出来再跳出整个循环  
            $eof = "";
            $num--;
        }
        fclose($fp);
    }
    return $lines;
}  

function getPreNameSpace($nameSpace='')
{
    $res = $nameSpace;
    if (strpos($nameSpace, '\\')) {
        $arr = explode('\\', $nameSpace);
        array_pop($arr);
        $res = implode('\\', $arr);
    }
    return $res;
}

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author Jroy
 */
function is_login(){
    $user = session('user_auth');
    if (empty($user)) {
        return 0;
    } else {
        return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
    }
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author Jroy
 */
function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
 * 字符串转换为数组，主要用于把分隔符调整到第二个参数
 * @param  string $str  要分割的字符串
 * @param  string $glue 分割符
 * @return array
 * @author Jroy
 */
function str2arr($str, $glue = ','){
    return explode($glue, $str);
}

/**
 * 数组转换为字符串，主要用于把分隔符调整到第二个参数
 * @param  array  $arr  要连接的数组
 * @param  string $glue 分割符
 * @return string
 * @author Jroy
 */
function arr2str($arr, $glue = ','){
    return implode($glue, $arr);
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 * @author Jroy
 */
function think_encrypt($data, $key = '', $expire = 0) {
    $key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    $str = sprintf('%010d', $expire ? $expire + time():0);

    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
    }
    return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * @return string
 * @author Jroy
 */
function think_decrypt($data, $key = ''){
    $key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data   = str_replace(array('-','_'),array('+','/'),$data);
    $mod4   = strlen($data) % 4;
    if ($mod4) {
       $data .= substr('====', $mod4);
    }
    $data   = base64_decode($data);
    $expire = substr($data,0,10);
    $data   = substr($data,10);

    if($expire > 0 && $expire < time()) {
        return '';
    }
    $x      = 0;
    $len    = strlen($data);
    $l      = strlen($key);
    $char   = $str = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else{
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}

/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author Jroy
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
    if(is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author Jroy
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 设置跳转页面URL
 * 使用函数再次封装，方便以后选择不同的存储方式（目前使用cookie存储）
 * @author Jroy
 */
function set_redirect_url($url){
    cookie('redirect_url', $url);
}

/**
 * 获取跳转页面URL
 * @return string 跳转页URL
 * @author Jroy
 */
function get_redirect_url(){
    $url = cookie('redirect_url');
    return empty($url) ? __APP__ : $url;
}

/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook,$params=array()){
    \Think\Hook::listen($hook,$params);
}

/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL,$format='Y-m-d H:i'){
    $time = $time === NULL ? time() : intval($time);
    return date($format, $time);
}


/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author Jroy
 */
function check_verify($code, $id = 1){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**
 * 获取导航URL
 * @param  string $url 导航URL
 * @return string      解析或的url
 * @author Jroy
 */
function get_nav_url($url){
    switch ($url) {
        case 'http://' === substr($url, 0, 7):
        case '#' === substr($url, 0, 1):
            break;        
        default:
            $url = U($url);
            break;
    }
    return $url;
}

/*html转text*/
function htmltotext($str)
{
     $str = preg_replace("/<sty(.*)\/style>|<scr(.*)\/script>|<!--(.*)-->/isU","",$str);
     $alltext = "";
     $start = 1;
     for($i=0;$i<strlen($str);$i++)
     {
          if($start==0 && $str[$i]==">"){
            $start = 1;
          }else if($start==1){
               if($str[$i]=="<"){
                    $start = 0;
                    $alltext .= " ";
               }else if(ord($str[$i])>31){
                    $alltext .= $str[$i];
               }
          }
     }
     $alltext = str_replace("　"," ",$alltext);
     $alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
     $alltext = preg_replace("/[ ]+/s"," ",$alltext);
     return $alltext;
}

//获取表名列表
function getTableNameList(){
	$dbType = C('DB_TYPE');
	$Model = new Model(); // 实例化一个model对象 没有对应任何数据表
	if($dbType == 'mysql'){
		$dbName = C('DB_NAME');
		$result = Array();
		$tempArray = $Model->query("select table_name from information_schema.tables where table_schema='".$dbName."' and table_type='base table'");
		foreach($tempArray as $temp){
			$result[] = $temp['table_name'];
		}
		return $result;
	}else{ //sqlite
		$result = Array();
		$tempArray = $Model->query("select * from sqlite_master where type='table' order by name");
		foreach($tempArray as $temp){
			$result[] = $temp['name'];
		}
		return $result;
	} 
	$this->error('数据库类型不支持');
}

//读取项目目录下的文件夹，供用户选择哪个才是module目录
function getModuleNameList(){
	$ignoreList = Array("Common","Runtime","TPH");
	$allFileList = getDirList(APP_PATH);
	return array_diff($allFileList, $ignoreList);
}

//获取列名列表
function getTableInfoArray($tableName){
	$dbType = C('DB_TYPE');
	$Model = new Model(); // 实例化一个model对象 没有对应任何数据表
	if($dbType == 'mysql'){
		$dbName = C('DB_NAME');
		$result = $Model->query("select * from information_schema.columns where table_schema='".$dbName."' and table_name='".C('DB_PREFIX').$tableName."'");
		return $result;
	}else{ //sqlite
		$result = $Model->query("pragma table_info (".C('DB_PREFIX').$tableName.")");
		return $result;
	} 
	$this->error('数据库类型不支持');
}


//根据数据库类型获取列名键
function getColumnNameKey(){
	$dbType = C('DB_TYPE');
	if($dbType == 'mysql'){
		return MYSQL_COLUMN_NAME_KEY;
	}else{
		return SQLITE_COLUMN_NAME_KEY;
	}
}

//仅获取目录列表
function getDirList($directory){
	$files = array();        
	try {        
		$dir = new \DirectoryIterator($directory);        
	} catch (Exception $e) {        
		throw new Exception($directory . ' is not readable');        
	}        
	foreach($dir as $file) {        
		if($file->isDot()) continue;        
		if($file->isFile()) continue;        
		$files[] = $file->getFileName();        
	}        
	return $files;  
}

//把带下划线的表名转换为驼峰命名（首字母大写）
function tableNameToModelName($tableName){
	$tempArray = explode('_', $tableName);
	$result = "";
	for($i = 0; $i < count($tempArray);$i++){
		$result .= ucfirst($tempArray[$i]);
	}
	return $result;
}

//把带下划线的列名转换为驼峰命名（首字母小写）
function columNameToVarName($columName){
	$tempArray = explode('_', $columName);
	$result = "";
	for($i = 0; $i < count($tempArray);$i++){
		$result .= ucfirst($tempArray[$i]);
	}
	return lcfirst($result);
}

    /**
 * 安全过滤函数
 *
 * @param $string
 * @return string
 */
    function safe_replace($string) {
        $string = str_replace('%20','',$string);
        $string = str_replace('%27','',$string);
        $string = str_replace('%2527','',$string);
        $string = str_replace('*','',$string);
        $string = str_replace('"','&quot;',$string);
        $string = str_replace("'",'',$string);
        $string = str_replace('"','',$string);
        $string = str_replace(';','',$string);
        $string = str_replace('<','&lt;',$string);
        $string = str_replace('>','&gt;',$string);
        $string = str_replace("{",'',$string);
        $string = str_replace('}','',$string);
        $string = str_replace('\\','',$string);
        $string = remove_xss($string);
        return $string;
    }
    /**
     * xss过滤函数
     *
     * @param $string
     * @return string
     */
    function remove_xss($string) { 
        $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $string);
        $parm1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $parm2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $parm = array_merge($parm1, $parm2); 
        for ($i = 0; $i < sizeof($parm); $i++) { 
            $pattern = '/'; 
            for ($j = 0; $j < strlen($parm[$i]); $j++) { 
                if ($j > 0) { 
                    $pattern .= '('; 
                    $pattern .= '(&#[x|X]0([9][a][b]);?)?'; 
                    $pattern .= '|(&#0([9][10][13]);?)?'; 
                    $pattern .= ')?'; 
                }
                $pattern .= $parm[$i][$j]; 
            }
            $pattern .= '/i';
            $string = preg_replace($pattern, '', $string); 
        }
        return $string;
    }
    function pager($select,$p,$display){
        R("Comm/Page/index",array($select,$p,$display));
    }
    function md5Encrypt($str){
        $key='*M3~A0!R9@C1"#H7%s2^o/f4-t?3';
        return md5(md5($str.$key).$key);
    }
    function get_time(){
        return date('Y-m-d H:i:s',time());
    }
    
    function logs($data,$result = false){
        $M = M('log');
        $M->update_user = session('userid');
        $M->update_time = time();
        $M->operate     = __SELF__;
        $M->content     = json_encode($data);
        $M->result      = $result;
        $M->ip          =  get_client_ip();
        $M->add();
    }
    function byteFormat($bytes) {
        $sizetext = array(" B", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        return round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . $sizetext[$i];
    }
    
    function curl($url,$post_data=null,$json=true){
        $ch= curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_NOSIGNAL, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        
        if(!empty($post_data)){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type: application/json","X-Accept: application/json"));
        }
        $result = curl_exec($ch);
        curl_close($ch);
        if($result===false) {return curl_error($ch);} 
        else {if($json)$result = json_decode($result,true); return $result;}
        
    }

    function saveM($M){
        $id=$M->getPk();
        if(empty($M->$id)){
            $result=$M->add();
        }
        else{
            $result=$M->save();
        }
        return $result;
    }
    function tagFilter($tags){
        $search=array(';','；','。','、','，');
        $symbol=',';
        $tags=str_replace($search, $symbol, $tags);
        return $tags;
    }
    function LazyInc($M,$column,$n=1){
        $M->switchModel("Adv")->setLazyInc($column,$n,6);
    }
    //POST数据处理
    //未输入值的txtbox为空，应当移除
    //复选框未选择，则不会出现在post中，应添加条件并赋值为false
    function queryFilter($data){
        foreach ($data as $key => $value) {
            if(empty($value) || empty($value[1])){
                unset($data[$key]);
            }
        }
        return $data;
    }
    /*
    tinyint(1) bool;
    char,varchar
    验证长度
    int,TINYINT,SMALLINT,MEDIUMINT,BIGINT
    验证数值和大小
    FLOAT,DOUBLE,DECIMAL
    验证数值
    TINYTEXT,TEXT,MEDIUMTEXT,LONGTEXT
    TINYBLOB,BLOB,MEDIUMBLOB,LONGBLOB
    验证长度
    BINARY,VARBINARY()
    验证长度
    DATE,date
    TIME,
    DATETIME,TIMESTAMP,
    YEAR 
    验证日期时间
    */
    function validator($vo){
        $str ='{';
        $str .= $vo['Null']=='NO'?'required:true,':'';
        $str .= strpos($vo['Type'],'char')!==false?'maxlength:'.substr($vo['Type'],strpos($vo['Type'],"(")+1,-1).',':'';
        if(strpos($vo['Type'],'int')!==false){
            $str .= 'digits:true,';
            switch(strtoupper(substr($vo['Type'],0,3)))
            {
                case 'TIN'://TINYINT
                    $str .= strpos($vo['Type'],'unsigned')!==false?'range:[0,255]':'range:[-128,127]';
                  break;  
               case 'SMA'://SMALLINT
                    $str .= strpos($vo['Type'],'unsigned')!==false?'range:[0,65535]':'range:[-32768,32767]';
                  break; 
                case 'MED'://MEDIUMINT
                    $str .= strpos($vo['Type'],'unsigned')!==false?'range:[0,16777215]':'range:[-8388608,8388607]';
                  break; 
                case 'INT'://INT
                    $str .= strpos($vo['Type'],'unsigned')!==false?'range:[0,4294967295]':'range:[-2147483648,2147483647]';
                  break; 
                case 'BIG'://BIGINT
                    $str .= strpos($vo['Type'],'unsigned')!==false?'range:[0,18446744073709551615]':'range:[-9223372036854775808,9223372036854775807]';
                  break; 
            }
        }
        $str .= strpos($vo['Type'],'decimal')!==false?'number:true,':'';
        $str .= strpos($vo['Type'],'float')!==false?'number:true,':'';
        $str .= strpos($vo['Type'],'double')!==false?'number:true,':'';
        $str .= strpos($vo['Type'],'year')!==false?'range:[0,9999],digits:true,':'';
        $str .= strpos($vo['Type'],'timestamp')!==false?'dateISO:true,':'';
        $str .= strpos($vo['Type'],'datetime')!==false?'dateISO:true,':'';
        $str .= strpos($vo['Type'],'time')!==false?'date:true,':'';
        $str.='}';
        return $str;
    }
    function control_type($vo){
        if($vo['Key']==='PRI')$type='hidden';
        elseif(strpos($vo['Type'],'char')!==false)$type='text';
        elseif(strpos($vo['Type'],'text')!==false)$type='area';
        elseif(strpos($vo['Type'],'enum')!==false)$type='select';
        elseif($vo['Type']=='datetime' || $vo['Type']=='timestamp')$type='datetime';
        elseif($vo['Type']=='date')             $type='date';
        elseif($vo['Type']=='time')             $type='time';
        elseif(strpos($vo['Type'],'bit')!==false)$type='checkbox';
        //else if(strpos($vo['type'],'set')!==false)$type='checkboxs';
        else if(
                strpos($vo['Type'],'int')!==false 
            ||  strpos($vo['Type'],'decimal')!==false 
            ||  strpos($vo['Type'],'float')!==false 
            ||  strpos($vo['Type'],'double')!==false
            )
            $type='digit';
        return $type;
    }
    function getNumb(){
        return array(
            'a' => 1, 
            '123' =>123, 
            'c' => 3, 
            'd' => 4, 
            );
    }
    function getName(){
        return array(
            'a' => 'a', 
            'b' => 'b', 
            'c' => 'c', 
            'd' => 'd', 
            );
    }
    function getStatus(){
        return array(
            '1' => 1, 
            '2' => 2, 
            '3' => 3, 
            '4' => 4, 
            );
    }
    function mkdirs($dir){
        if(!is_dir($dir)){       
            if(!mkdirs(dirname($dir))){       
                return false;       
            }
            if(!file_exists($dir)){
                if(!mkdir($dir,0777)){       
                    return false;       
                }
            }
            return true; 
        }
        return true;       
    }

    