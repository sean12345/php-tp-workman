<?php
/**
 * SMS短信发送日志信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace SMS\Model\AntNest;

class MsgSendLogModel extends CommonModel {
    protected $trueTableName = 'ant_msg_send_log';
    protected $connection = 'DB_ANT_NEST';
    // protected $tablePrefix = 'ant_';

    const SEND_SUCCESS = 0; // 短信发送成功
    const SEND_FAILD = 1; // 短信发送失败

    /* 自动验证规则 */
    protected $_validate = array(

    );

    /* 模型自动完成 */
    protected $_auto = array(
        array('remark', '', self::MODEL_INSERT),
        array('createtime', 'timeNow', self::MODEL_INSERT, 'function'),
    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'log_id' , //  任务ID
        'appkey', // 'appkey',
        'mobile', // '电话',
        'gateway', // '短信网关名称',
        'msg_type', // '短信类型编号',
        'msg_var', // '短信模板参数',
        'response_code', // '短信发送结果',
        'remark', // '备注',
        'request_time', // '请求时间',
        'createtime', // '创建时间',
        '_pk'=>'log_id',
        '_type'=>array(
            'log_id'=>'int',
        ),
    );

    protected $_scope = array(
        /*发送成功的短信*/
        'send_success' => array(
            'where' => array('response_type' => self::SEND_SUCCESS),
        ),
    );


}

