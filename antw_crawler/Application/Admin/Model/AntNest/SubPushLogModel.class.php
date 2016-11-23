<?php
/**
 * 拍单订阅推送日志信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Admin\Model\AntNest;

class SubPushLogModel extends CommonModel {
    protected $trueTableName = 'ant_auction_subpush_log';
    protected $connection = 'DB_ANT_NEST';
    // protected $tablePrefix = 'ant_';

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
        'log_id' , //  log ID
        'app_key' , //  jpush appkey
        'app_secret' , //  jpush secret
        'order_id' , //  拍单ID
        'notice_info' , //  通知消息内容
        'jpush_id' , //  jpush_id 集合
        'response_code' , //  推送结果(200:成功)
        'remark' , //  备注
        'request_time' , //  请求时间
        'createtime' , //  创建时间
        '_pk'=>'log_id',
        '_type'=>array(
            'log_id'=>'int',
        ),
    );

    protected $_scope = array(
        /*发送成功的短信*/
        'send_success' => array(
            'where' => array('response_code' => 200),
        ),
    );


}

