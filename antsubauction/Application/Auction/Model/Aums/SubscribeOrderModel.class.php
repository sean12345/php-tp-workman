<?php
/**
 * 订阅拍单信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Model\Aums;

class SubscribeOrderModel extends CommonModel {
    protected $trueTableName = 'au_subscribe_order';
    protected $connection = 'DB_AUMS';
    // protected $tablePrefix = 'au_';

    const SEND_SUCCESS = 0; // 短信发送成功
    const SEND_FAILD = 1; // 短信发送失败

    /* 自动验证规则 */
    protected $_validate = array(

    );

    /* 模型自动完成 */
    protected $_auto = array(
        array('createtime', 'timeNow', self::MODEL_INSERT, 'function'),
    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'sid' , //  订阅ID
        'uid', // 车商ID,
        'order_id', // 订阅器名称,
        'createtime', // '创建时间',
        '_pk'=>'sid',
        '_type'=>array(
            'sid'=>'int',
        ),
    );

    protected $_scope = array(
    );


}

