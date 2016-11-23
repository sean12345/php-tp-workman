<?php
namespace SMS\Service\MsgGateWay;

use SMS\Org\NetCom;
use SMS\Service\MsgLogService;
use Base\ExceptionHandler;
use SMS\Service\MsgGateWay\Extension\MsgGateWayInterface;

/**
 * 发送信息平台 -- 中国优质短信平台c123.com
 * 
 */
class Chinamsg implements MsgGateWayInterface {
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
        $templates =  C('SMS_API.COMMON')['TPL']; 
        $config =  C('SMS_API.CHINAMSG'); 
        $apiKEY = $config['API_KEY'];
        $apiAC = $config['API_AC'];
        $apiCGID = $config['API_CGID'];
        $apiCSID = $config['API_CSID'];
        $apiTPL = $config['TPL'];
        $tpl_id = !empty($apiTPL[$number]['tpl_id']) ? $apiTPL[$number]['tpl_id'] : '';
        if (!$tpl_id) {
            ExceptionHandler::make_throw('0002');
        }
        $diff_key = array_diff_key($apiTPL[$number]['var_list'], $params);
        if (count($diff_key) > 0) {
            ExceptionHandler::make_throw('0003');
        }
        $this->c = $templates[$tpl_id];
        foreach($params as $pk=>$pv){
            $this->c = str_replace("#".$pk."#",$pv,$this->c);
        }
        $data = [
            'action' => 'sendOnce',
            'ac' => $apiAC,
            'authkey' => $apiKEY,
            'cgid' => $apiCGID,
            'c' => $this->c,
            'csid' => $apiCSID,
            't' => '', //发送时间, 置空
            'm' => $mobile,
        ];
        $xml = NetCom::postSMS($config['API_URL'], $data);
        $res = simplexml_load_string(utf8_encode($xml));
        $resLog = $this->saveMsgSendLog($appkey, $number, $mobile, $requestTime, $params, $res['result']);
        if (!$resLog) {
            ExceptionHandler::make_throw('0012');
        }
        return isset($res['result']) && $res['result'] == 1 ? true : false;
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
    private function saveMsgSendLog($appkey='', $number='', $mobile='', $requestTime='', $params=array(), $resultCode) {
        $paramsLog = array(
            'appkey' => $appkey,
            'mobile' => $mobile,
            'gateway' => 'CHINAMSG',
            'msg_type' => $number,
            'msg_var' => json_encode($params),
            'response_code' => trim($resultCode),
            'request_time' => $requestTime,
        );
        if($resultCode == 1){
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
                $errorMsg = "帐户格式不正确(正确的格式为:员工编号@企业编号)";
                break;
            case -1:
                $errorMsg = "服务器拒绝(速度过快、限时或绑定IP不对等)如遇速度过快可延时再发";
                break;
            case -2:
                $errorMsg = "密钥不正确";
                break;
            case -3:
                $errorMsg = "密钥已锁定";
                break;
            case -4:
                $errorMsg = "参数不正确(内容和号码不能为空，手机号码数过多，发送时间错误等)";
                break;
            case -5:
                $errorMsg = "无此帐户";
                break;
            case -6:
                $errorMsg = "帐户已锁定或已过期";
                break;
            case -7:
                $errorMsg = "帐户未开启接口发送";
                break;
            case -8:
                $errorMsg = "不可使用该通道组";
                break;
            case -9:
                $errorMsg = "帐户余额不足";
                break;
            case -10:
                $errorMsg = "内部错误";
                break;
            case -11:
                $errorMsg = "扣费失败";
                break;
            default:break;
        }
        return $errorMsg;
    }
}
