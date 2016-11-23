<?php
namespace Admin\Service;

use Base\ExceptionHandler;
use Base\BaseService;

class MsgLogService extends CommonService{

    Protected $autoCheckFields = false;

    /**
     * 按应用统计短信发送情况
     * 
     * @param  string $bgnTime [description]
     * @param  string $endTime [description]
     * 
     * @return mix
     */
    public function getStatisticByApp($bgnTime='', $endTime='')
    {
        $res = array();
        $condition = array();
        if ($bgnTime > 0 && $endTime > 0) {
            $condition['createtime'] = array(
                                                        array('EGT', $bgnTime),
                                                        array('ELT', $endTime),
                                                        );
        } elseif ($bgnTime > 0) {
            $condition['createtime'] = array('EGT', $bgnTime);
        } elseif ($endTime > 0) {
            $condition['createtime'] = array('ELT', $endTime);
        }
        $fields = "appkey, count(*) as total, ";
        $fields .= "sum(if((gateway='YUNPIAN' and response_code=0) or (gateway='CHINAMSG' and response_code=1), 1, 0)) as success ";
        $res = D('AntNest\MsgSendLog')->field($fields)
                                                        ->group('appkey')
                                                        ->where($condition)
                                                        ->select();
        return $res;
    }

    /**
     * 按短信网关统计短信发送情况
     * 
     * @param  string $bgnTime [description]
     * @param  string $endTime [description]
     * 
     * @return mix
     */
    public function getStatisticByGateway($bgnTime='', $endTime='')
    {
        $res = array();
        $condition = array();
        if ($bgnTime > 0 && $endTime > 0) {
            $condition['createtime'] = array(
                                                        array('EGT', $bgnTime),
                                                        array('ELT', $endTime),
                                                        );
        } elseif ($bgnTime > 0) {
            $condition['createtime'] = array('EGT', $bgnTime);
        } elseif ($endTime > 0) {
            $condition['createtime'] = array('ELT', $endTime);
        }
        $fields = "gateway, count(*) as total, ";
        $fields .= "sum(if((gateway='YUNPIAN' and response_code=0) or (gateway='CHINAMSG' and response_code=1), 1, 0)) as success ";
        $res = D('AntNest\MsgSendLog')->field($fields)
                                                        ->group('gateway')
                                                        ->where($condition)
                                                        ->select();
        return $res;
    }

    /**
     * 按时间段查询日志
     * 
     * @param  string $bgnTime [description]
     * @param  [type] $endTime [description]
     * @return [type]          [description]
     */
    public function getLogList($bgnTime='', $endTime='', $pageNum=1, $pageSep=10)
    {
        $res = array();
        $condition = array();
        if ($bgnTime > 0 && $endTime > 0) {
            $condition['createtime'] = array(
                                                        array('EGT', $bgnTime.' 00:00:00'),
                                                        array('ELT', $endTime.' 23:59:59'),
                                                        );
        } elseif ($bgnTime > 0) {
            $condition['createtime'] = array('EGT', $bgnTime.' 00:00:00');
        } elseif ($endTime > 0) {
            $condition['createtime'] = array('ELT', $endTime.' 23:59:59');
        }
        $scope = array(
                            'limit' => $pageSep,
                            'where' => $condition,
                            'order' => 'createtime desc',
                            );
        $re = D('MsgSendLog')->scope($scope)->select();
        $count = D('MsgSendLog')->scope($scope)->count();
        $res = array(
                        'rows' => $re,
                        'count' => $count,
                        );
        return $res;
    }

}