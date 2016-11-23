<?php
/**
 * 员工账号管理日志信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Ucenter\Model\AntNest;

class EmployeeAccountOptionLogModel extends CommonModel {    
    protected $connection = 'DB_ANT_NEST';
    // protected $tableName = 'dealer_account_option_log';
    protected $trueTableName  = 'uc_employee_account_option_log';
    protected $pk = 'log_id';

    /* 自动验证规则 */
    protected $_validate = array(
        array('account_id', 'require', '账号ID不能为空!', self::MODEL_INSERT),
    );

    /* 模型自动完成 */
    protected $_auto = array(
        array('createtime', 'timeNow', self::MODEL_INSERT, 'function'),
    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'log_id' ,
        'appkey', //客户端应用APPKEY
        'dev_type', // 客户端设备类型
        'account_id', // 账号ID
        'opt_type', // 操作类型
        'option', // 操作内容
        'remark', // '备注',
        'manager_account_id', // 操作人账号ID
        'manager_ip', // 登录IP
        'createtime', // 创建时间
        '_pk'=>'log_id',
        '_type'=>array(
            'log_id'=>'int',
        ),
    );

    protected $_scope = array(
    );
}

