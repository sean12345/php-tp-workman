<?php
/**
 * SMS短信网关信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Admin\Model\AntNest;

class MsgGatewayModel extends CommonModel {
    protected $trueTableName = 'ant_msg_gateway';
    protected $connection = 'DB_ANT_NEST';
    protected $tablePrefix = 'ant_';

    const STATUS_INVALID = 0; // 无效短信网关
    const STATUS_VALID = 1; // 有效短信网关

    const IS_CURRENT_NO = 0; // 短信网关当前未在使用中
    const IS_CURRENT_YES = 1; // 短信网关当前正在使用中

    /* 自动验证规则 */
    protected $_validate = array(

    );

    /* 模型自动完成 */
    protected $_auto = array(
        array('remark', '', self::MODEL_INSERT),
        array('createtime', 'timeNow', self::MODEL_INSERT, 'function'),
        array('updatetime', 'timeNow', self::MODEL_UPDATE, 'function'),
    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'gateway_id' , //  任务ID
        'gateway_name', // '短信网关名称',
        'status', // '短信网关状态(0:无效, 1:有效)',
        'is_current', // '是否当前正在使用(0:未使用, 1:正在使用)',
        'remark', // '备注',
        'createtime', // '创建时间',
        'updatetime', // '更新时间',
        '_pk'=>'gateway_id',
        '_type'=>array(
            'gateway_id'=>'int',
        ),
    );

    protected $_scope = array(
        /*有效短信网关集合*/
        'gateway_list_valid' => array(
            'where' => array('status' => self::STATUS_VALID),
        ),
        /*当前正在使用的短信网关*/
        'gateway_current' => array(
            'where' => array('is_current' => self::IS_CURRENT_YES),
        ),
    );

    /**
     * 切换当前正在使用的网关
     *
     * @param string  $gatewayName
     * 
     * @return mix
     */
    public function changeCurrent($gatewayName = '') {
        $res = false;
        $mod = M('MsgGateway');
        $re = $mod->where('is_current=' . self::IS_CURRENT_YES)->setField('is_current', self::IS_CURRENT_NO);
        if ($re) {
            $res = $mod->where(array('gateway_name'=>$gatewayName))->setField('is_current', self::IS_CURRENT_YES);
        }
        return $res;
    }


}

