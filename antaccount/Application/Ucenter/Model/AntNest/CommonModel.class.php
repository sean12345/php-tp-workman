<?php
/**
 * 基础模型
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Ucenter\Model\AntNest;

use Base\BaseModel;

class CommonModel extends BaseModel {

    /*客户设备类型*/
    const DEV_TYPE_ANDROID = 1;
    const DEV_TYPE_IOS = 2;
    const DEV_TYPE_WEB_MOBILE = 3;
    const DEV_TYPE_WEB_PC = 4;

    /*账号状态*/
    const ACCOUNT_STATUS_PENDING = 0; // 未激活
    const ACCOUNT_STATUS_ACTIVE = 1; // 已启用
    const ACCOUNT_STATUS_INACTIVE = 2; // 已禁用
    const ACCOUNT_STATUS_CANCEL = 3; // 已销毁

    /*账号活动类型*/
    const ACTION_TYPE_REGIST = 1; // 注册
    const ACTION_TYPE_LOGIN = 2; // 登录
    const ACTION_TYPE_LOGOUT = 3; // 退出
    const ACTION_TYPE_RETRIEVEPWD = 4; // 找回密码
    const ACTION_TYPE_CHANGEPWD = 5; // 设置密码
    const ACTION_TYPE_SETPROFILE = 6; // 修改账号资料

    /*账号操作类型*/
    const OPTION_TYPE_ADD = 1; // 添加用户
    const OPTION_TYPE_ACTIVE = 2; // 启用用户
    const OPTION_TYPE_INACTIVE = 3; // 禁用用户
    const OPTION_TYPE_CANCEL = 4; // 销毁用户
    const OPTION_TYPE_RESETPWD = 5; // 重置密码
    const OPTION_TYPE_SETPROFILE = 6; // 修改账号资料

    /*账号类型*/
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

    protected $SexTypes =  array(
      'SEX_MALE' => self::SEX_MALE,
      'SEX_FEMALE' => self::SEX_FEMALE,
    );

    /*客户设备类型集合*/
    protected $devTypes =  array(
      'DEV_TYPE_ANDROID' => self::DEV_TYPE_ANDROID,
      'DEV_TYPE_IOS' => self::DEV_TYPE_IOS,
      'DEV_TYPE_WEB_MOBILE' => self::DEV_TYPE_WEB_MOBILE,
      'DEV_TYPE_WEB_PC' => self::DEV_TYPE_WEB_PC,
    );

    /*用户状态集合*/
    protected $accountStatus = array(
        'ACCOUNT_STATUS_PENDING' => self::ACCOUNT_STATUS_PENDING,
        'ACCOUNT_STATUS_ACTIVE' => self::ACCOUNT_STATUS_ACTIVE,
        'ACCOUNT_STATUS_INACTIVE' => self::ACCOUNT_STATUS_INACTIVE,
        'ACCOUNT_STATUS_CANCEL' => self::ACCOUNT_STATUS_CANCEL,
    );

    public function getAccountStatus() {
        return $this->accountStatus;
    }

}

