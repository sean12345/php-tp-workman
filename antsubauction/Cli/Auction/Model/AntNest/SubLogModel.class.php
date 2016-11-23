<?php
/**
 * 拍单订阅推送日志信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Model\AntNest;

class SubLogModel extends CommonModel {
    protected $trueTableName = 'ant_auction_sub_log';
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
        'appkey' , //  AN appkey
        'account_id' , //  拍单审核人ID
        'order_id' , //  拍单ID
        'task_content' , //  拍单订阅任务内容
        'distribute_status' , //  拍单订阅分发结果 (1:成功, 0:失败)
        'remark' , //  备注
        'request_time' , //  请求时间
        'createtime' , //  创建时间
        '_pk'=>'log_id',
        '_type'=>array(
            'log_id'=>'int',
        ),
    );

    protected $_scope = array(
        /*分发成功的订阅信息*/
        'send_success' => array(
            'where' => array('distribute_status' => 1),
        ),
    );


}

