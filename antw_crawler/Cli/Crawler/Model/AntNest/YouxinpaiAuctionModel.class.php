<?php
/**
 * 优信拍拍单数据信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Crawler\Model\AntNest;

class YouxinpaiAuctionModel extends CommonModel {
    protected $trueTableName = 'crawler_yxp_auction';
    protected $connection = 'DB_ANT_NEST';
    // protected $tablePrefix = 'ant_';

    /* 自动验证规则 */
    protected $_validate = array(

    );

    /* 模型自动完成 */
    protected $_auto = array(
        array('remark', '', self::MODEL_INSERT),
        array('createtime', 'timeNow', self::MODEL_INSERT, 'function'),
        array('updatetime', 'timeNow', self::MODEL_BOTH, 'function'),
    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'id', // 自增ID,
        'publish_id', // '拍单ID',
        'publish_type', // '拍卖类型',
        'hprice', // '最高价',
        'total_price', // '总价',
        'trade_price', // '成交价',
        'buyer_agent_fee', // '代办费',
        'buyer_trade_fee', // '交易服务费',
        'resp_code', // '拍单拍卖状态(-3:车辆流拍, -7:竞价结束之后处理中, -12:等待竞价, -15:车辆成交)',
        'is_start_auction', // '是否正在加价(1:正在加价)',
        'Is_over_reser', // '是否超过保留价',
        'remark', // '备注',
        'createtime', // '创建时间',
        'updatetime', // '更新时间',
        '_pk'=>'id',
        '_type'=>array(
            'id'=>'int',
        ),
    );

    protected $_scope = array(

    );


}

