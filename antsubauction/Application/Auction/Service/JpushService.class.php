<?php
namespace Auction\Service;

use Base\ExceptionHandler;
use Base\BaseService;

class JpushService extends BaseService{
    Protected $autoCheckFields = false;

    public function __construct() {
    }

    /**
     * Jpush消息推送处理
     *
     * @param array $params
     * 
     * @return mix
     */
    public function jpushSend($params=array()) {
        $res = array();
        $appKey = C('JPUSH_LAIPAICHE_APPKEY');
        $masterSecret = C('JPUSH_LAIPAICHE_SECRET');
        $registrationID = !empty($params['jpush_id']) ? $params['jpush_id'] : '';
        $mobile = !empty($params['mobile']) ? $params['mobile'] : '';
        $noticeInfo = !empty($params['notice_info']) ? $params['notice_info'] : '';
        import('Org.JPush.Autoloader', APP_PATH, '.php');
        $client = new \JPush\Client($appKey, $masterSecret);
        $contentData = array(
            'type' => !empty($params['jpush_type']) ? $params['jpush_type'] : '',
            'data' => !empty($params['jpush_data']) ? json_encode($params['jpush_data']) : '',
        );
        try {
            $resPush = $client->push()
                ->setPlatform(array('ios', 'android'))
                ->addRegistrationId($registrationID)
                ->iosNotification($noticeInfo, array(
                    'extras' => $contentData,
                ))
                ->androidNotification($noticeInfo, array(
                    'title' => '来拍车',
                    'build_id' => 2,
                    'extras' => $contentData,
                ))
                ->options(array(
                    'sendno' => 1000015, // 推送序号
                    'time_to_live' => 86400, // 离线消息保留时长(秒) 默认 86400 （1 天），最长 10 天
                    'apns_production' => true, // APNs是否生产环境
                    // 'big_push_duration' => 100 // 定速推送时长(分钟), 不建议打开
                ))
                ->send();
        } catch (\JPush\Exceptions\APIConnectionException $e) {
            $resPush = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
            );
        } catch (\JPush\Exceptions\APIRequestException $e) {
            $resPush = array(
                    'code' => $e->getCode(),
                    'msg' => $e->getMessage(),
            );
        }
        // 记录推送日志
        $pushLog = array(
            'app_key' => $appKey,
            'app_secret' => $masterSecret,
            'mobile' => $mobile,
            'notice_info' => $noticeInfo,
            'jpush_id' => $registrationID,
            'response_code' => (isset($resPush['http_code']) && $resPush['http_code'] == '200') ? '200' : (!empty($resPush['code']) ? $resPush['code'] : ''),
            'remark' => (isset($resPush['http_code']) && $resPush['http_code'] == '200') ? 'OK' : (!empty($resPush['msg']) ? $resPush['msg'] : ''),
            'request_time' => !empty($params['request_time']) ? $params['request_time'] : ''
        );
        $res = D('JpushLog', 'Service')->saveJpushLog($pushLog);
        return $res ? true : false;
    }

}