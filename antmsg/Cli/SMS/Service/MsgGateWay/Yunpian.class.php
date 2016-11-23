<?php
namespace SMS\Service\MsgGateWay;

use SMS\Org\NetCom;
use SMS\Service\MsgLogService;
use Base\ExceptionHandler;
use SMS\Service\MsgGateWay\Extension\MsgGateWayInterface;

/**
 * 发送短信平台 - 云片
 * 
 */
class Yunpian implements MsgGateWayInterface {
    /**
     * 短信发送发放
     * 
     * @param  string  $appkey  appkey应用授权编号
     * @param  string  $mobile  短信接收人电话
     * @param  int  $number  短信自定义类型
     * @param  int  $requestTime  请求时间
     * @param  array  $params  短信模块参数
     * 
     * @return array
     */
    public function msgSend($appkey='', $mobile='', $number='', $requestTime='', $params=array())
    {
        $config =  C('SMS_API.YUNPIAN'); 
        $apiKEY = $config['API_KEY'];
        $apiTPL = $config['TPL'];
        $tpl_id = !empty($apiTPL[$number]['tpl_id']) ? $apiTPL[$number]['tpl_id'] : '';
        if (!$tpl_id) {
            ExceptionHandler::make_throw('0002');
        }
        $diff_key = array_diff_key($apiTPL[$number]['var_list'], $params);
        if (count($diff_key) > 0) {
            ExceptionHandler::make_throw('0003');
        }
        $params = array_intersect_key($params, $apiTPL[$number]['var_list']);
        $var_list_tpl = array();
        foreach ($params as $key => $value) {
            $var_list_tpl['#' . $key . '#'] = $value;
        }
        $var_list_tpl = http_build_query($var_list_tpl);
        $tpl_value = $var_list_tpl;
        $encoded_tpl_value = urlencode($tpl_value);  //tpl_value需整体转义        
        $post_string = "apikey=$apiKEY&tpl_id=$tpl_id&tpl_value=$encoded_tpl_value&mobile=$mobile";
        $resMsg = NetCom::sock_post($config['API_URL'], $post_string);
        $res = json_decode($resMsg, true);
        $resLog = $this->saveMsgSendLog($appkey, $number, $mobile, $requestTime, $params, $res['code']);
        if (!$resLog) {
            ExceptionHandler::make_throw('0012');
        }
        return isset($res['code']) && $res['code'] == 0 ? true : false;
    }

    /**
     * 记录短信发送日志
     *
     * @param int $appkey
     * @param int $number
     * @param int $mobile
     * @param int $requestTime
     * @param array $params
     * @param int $resultCode
     * 
     * @return boolean
     */
    private function saveMsgSendLog($appkey='', $number='', $mobile='', $requestTime='', $params=array(), $resultCode='') {
        $paramsLog = array(
            'appkey' => $appkey,
            'mobile' => $mobile,
            'gateway' => 'YUNPIAN',
            'msg_type' => $number,
            'msg_var' => json_encode($params),
            'response_code' => $resultCode,
            'request_time' => $requestTime,
        );
        if($resultCode == 0){
            $paramsLog['remark'] = 'OK';
        } else {  
            //发送失败的返回值
            $errorMsg = $this->getErrorMsg($resultCode);
            $paramsLog['remark'] = !empty($errorMsg) ? $errorMsg : '';
        }        
        $res = D('SMS/MsgLog', 'Service')->msgSendLog($paramsLog);
        return $res;
    }

    /**
     * 获取短信网关错误详情
     *
     * @param int $errorCode
     * 
     * @return string
     */
    private function getErrorMsg($errorCode='') {
        $errorMsg = '';
        $errorCode = trim($errorCode);
        switch ($errorCode) {
            case 0:
                $errorMsg = "OK";
                break;
            case 1:
                $errorMsg = "请求参数缺失";
                break;
            case 2:
                $errorMsg = "请求参数格式错误";
                break;
            case 3:
                $errorMsg = "账户余额不足";
                break;
            case 4:
                $errorMsg = "关键词屏蔽";
                break;
            case 5:
                $errorMsg = "未找到对应id的模板";
                break;
            case 6:
                $errorMsg = "添加模板失败";
                break;
            case 7:
                $errorMsg = "模板不可用";
                break;
            case 8:
                $errorMsg = "同一手机号30秒内重复提交相同的内容";
                break;
            case 9:
                $errorMsg = "同一手机号5分钟内重复提交相同的内容超过3次";
                break;
            case 10:
                $errorMsg = "手机号黑名单过滤";
                break;
            case 11:
                $errorMsg = "接口不支持GET方式调用";
                break;
            case 12:
                $errorMsg = "接口不支持POST方式调用";
                break;
            case 13:
                $errorMsg = "营销短信暂停发送";
                break;
            case 14:
                $errorMsg = "解码失败";
                break;
            case 15:
                $errorMsg = "签名不匹配";
                break;
            case 16:
                $errorMsg = "签名格式不正确";
                break;
            case 17:
                $errorMsg = "24小时内同一手机号发送次数超过限制";
                break;
            case 18:
                $errorMsg = "签名校验失败";
                break;
            case 19:
                $errorMsg = "请求已失效";
                break;
            case 20:
                $errorMsg = "不支持的国家地区";
                break;
            case 21:
                $errorMsg = "解密失败";
                break;
            case 22:
                $errorMsg = "1小时内同一手机号发送次数超过限制";
                break;
            case 23:
                $errorMsg = "发往模板支持的国家列表之外的地区";
                break;
            case 24:
                $errorMsg = "添加告警设置失败";
                break;
            case 25:
                $errorMsg = "手机号和内容个数不匹配";
                break;
            case 26:
                $errorMsg = "流量包错误";
                break;
            case 27:
                $errorMsg = "未开通金额计费";
                break;
            case 28:
                $errorMsg = "运营商错误";
                break;
            case 33:
                $errorMsg = "超过频率";
                break;
            case -1:
                $errorMsg = "非法的apikey";
                break;
            case -2:
                $errorMsg = "API没有权限";
                break;
            case -3:
                $errorMsg = "IP没有权限";
                break;
            case -4:
                $errorMsg = "访问次数超限";
                break;
            case -5:
                $errorMsg = "访问频率超限";
                break;
            case -50:
                $errorMsg = "未知异常";
                break;
            case -51:
                $errorMsg = "系统繁忙";
                break;
            case -52:
                $errorMsg = "充值失败";
                break;
            case -53:
                $errorMsg = "提交短信失败";
                break;
            case -54:
                $errorMsg = "记录已存在";
                break;
            case -55:
                $errorMsg = "记录不存在";
                break;
            case -57:
                $errorMsg = "用户开通过固定签名功能，但签名未设置";
                break;
            default:
                break;
        }
        return $errorMsg;
    }

}
