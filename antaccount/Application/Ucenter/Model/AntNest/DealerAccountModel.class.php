<?php
/**
 * 用户账号信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Ucenter\Model\AntNest;

use Base\ExceptionHandler;

class DealerAccountModel extends CommonModel {

    protected $connection = 'DB_ANT_NEST';
    // protected $tableName = 'dealer_account';
    protected $trueTableName  = 'uc_dealer_account';
    protected $pk = 'account_id';

    /* 自动验证规则 */
    protected $_validate = array(
        // array('account_id','require','账号ID不能为空!', self::MODEL_UPDATE),
        // array('pwd','require','账号密码不能为空!', self::MODEL_INSERT),
        // array('mobile','require','手机号码不能为空!', self::MODEL_INSERT),
        // array('account_name','require','账号名称不能为空!', self::MODEL_INSERT),
        // array('account_id','require','0901', self::MODEL_INSERT),
        // array('account_id', '', '0902', 1, 'unique', self::MODEL_BOTH),
        array('email', '/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', '0108', 0),
        array('mobile', '/^1[34578]\d{9}$/', '0105', MODEL_UPDATE),
        // array('pwd', '/^([a-zA-Z0-9@*#]{6,22})$/', '0113', 0), // 正则验证密码 [需包含字母数字以及@*#中的一种,长度为6-22位]
        array('account_name', '', '0103', 1, 'unique', self::MODEL_BOTH),
        array('mobile', '', '0106', 1, 'unique', self::MODEL_BOTH),
        // array('email', '', '0109', 1, 'unique', self::MODEL_BOTH),
        array('sex', 'checkSexType', '0907', self::MODEL_BOTH, 'callback'),
        array('province_id', '/^\d{0,8}$/', '0908', self::MODEL_BOTH),
        array('city_id', '/^\d{0,8}$/', '0909', self::MODEL_BOTH),
        array('nick_name', '/^[\x4E00-\x9FA5\w]{0,16}$/', '0905', self::MODEL_BOTH),
        // array('account_name,email,mobile,account_type', 'checkUserName', '用户名验证失败！', self::MODEL_BOTH, 'callback', array('123')),
        // array('account_name,email,mobile,account_type', 'checkUserName', '用户名验证失败！', 3, 'callback'),
    );

    /* 模型自动完成 */
    protected $_auto = array(
        array('createtime', 'timeNow', self::MODEL_INSERT, 'function'),
        array('updatetime', 'timeNow', self::MODEL_UPDATE, 'function'),
        // array('pwd', 'generatePassword', self::MODEL_INSERT, 'function'),
        // array('pwd', 'md5', self::MODEL_INSERT, 'function'),
    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'account_id' , //  用户ID
        'account_name', // 用户名称
        'email', // 电子邮件地址
        'pwd', // 用户密码
        'mobile', // 电话
        'status', // 账号状态
        'nick_name', // 昵称
        'real_name', // 真实姓名
        'u_idcard', // 身份证
        'account_avatar', // 个人头像
        'sex', // 性别
        'province_id', // 省份
        'city_id', // 城市
        'address', // 地址
        'las_login_time', // 最后登录时间
        'createtime', // 创建时间
        'updatetime', // 更新时间
        '_pk'=>'account_id',
        '_type'=>array(
            'account_id'=>'int',
        ),
    );

    protected $_scope = array(
        /*未激活*/
        'account_status_pending' => array(
            'where' => array('status' => parent::ACCOUNT_STATUS_PENDING),
        ),
        /*已启用*/
        'account_status_active' => array(
            'where' => array('status' => parent::ACCOUNT_STATUS_ACTIVE),
        ),
        /*已禁用*/
        'account_status_active' => array(
            'where' => array('status' => parent::ACCOUNT_STATUS_INACTIVE),
        ),
        /*已销毁*/
        'account_status_cancel' => array(
            'where' => array('status' => parent::ACCOUNT_STATUS_CANCEL),
        ),
    );

    /**
     *  判断账号是否存在
     *
     * @param  int $accountID 
     * 
     * @return boolean
     */
    public function isAaccountExist($accountID = '') {
        $res = false;
        $counts = $this->where('account_id='.$accountID)->count();
        $res = $counts > 0 ? true : false;
        return $res;
    }

}

