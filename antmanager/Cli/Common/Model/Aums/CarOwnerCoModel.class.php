<?php
/**
 * 车主信息采集原表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Common\Model\Aums;

// use Base\Model\CommonModel;

class CarOwnerCoModel extends CommonModel {
    /* 自动验证规则 */
    protected $_validate = array(
        array('comefromurl', 'url', 'URL格式不正确', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),        
        // /* 验证用户名 */
        // array('username', '1,30', -1, self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
        // array('username', 'checkDenyMember', -2, self::EXISTS_VALIDATE, 'callback'), //用户名禁止注册
        // array('username', '', -3, self::EXISTS_VALIDATE, 'unique'), //用户名被占用

        // /* 验证密码 */
        // array('password', '6,30', -4, self::EXISTS_VALIDATE, 'length'), //密码长度不合法

        // /* 验证邮箱 */
        // array('email', 'email', -5, self::EXISTS_VALIDATE), //邮箱格式不正确
        // array('email', '1,32', -6, self::EXISTS_VALIDATE, 'length'), //邮箱长度不合法
        // array('email', 'checkDenyEmail', -7, self::EXISTS_VALIDATE, 'callback'), //邮箱禁止注册
        // array('email', '', -8, self::EXISTS_VALIDATE, 'unique'), //邮箱被占用

        // /* 验证手机号码 */
        // array('mobile', '//', -9, self::EXISTS_VALIDATE), //手机格式不正确 TODO:
        // array('mobile', 'checkDenyMobile', -10, self::EXISTS_VALIDATE, 'callback'), //手机禁止注册
        // array('mobile', '', -11, self::EXISTS_VALIDATE, 'unique'), //手机号被占用
    );

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('status', 1, self::MODEL_INSERT, 'string'),        
        // array('password', 'think_ucenter_md5', self::MODEL_BOTH, 'function', UC_AUTH_KEY),
        // array('reg_time', NOW_TIME, self::MODEL_INSERT),
        // array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
        // array('update_time', NOW_TIME),
    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'owner_co_id',
        'uid', // 用户ID
        'phone', // 手机号
        'area_id', // 车牌注册地
        'register_at', // 上牌时间
        'mileage', // 行驶里程(万公里)
        'name', // 姓名
        'sex', // 性别
        'model_id', // 车辆类型ID
        'province_id', // 省份ID
        'city_id', // 城市ID
        'district_id', // 地区ID
        'street_id', // 街道ID
        'seller_address', // 详细地址
        'cid', // 已分配的车辆CID
        'master_branch', // 主品牌
        'sended_at', // 分配时间
        'created_at', // 创建时间
        'series', // 系列
        'master_id', // 主品牌ID
        'series_id', // 系列ID
        'status', // 0无效 1有效
        'comefrom', // 来源
        'comefromid', // 原ID
        'comefromurl', // 原始url
        'comefrom_createtime', // 原始创建时间
        'comefrom_province', // 原始省份
        'comefrom_city', // 原始城市
        'imported', // 入库标记0,未入库 1已入库
        'comefrom_pid',
        'comefrom_cid',
        'comefrom_data',
        'comefrom_last_page',
        '_pk'=>'owner_co_id',
        '_type'=>array(
            'uid'=>'int',
            'area_id'=>'int',
        ),
    );

    protected $_scope = array(
        /*待导入数据*/
        'wait_import' => array(
            'where' => array('imported' => 0, 'status' => 1,),
        ),
    );

    public function test() {
        return $this->connection;
    }


}

