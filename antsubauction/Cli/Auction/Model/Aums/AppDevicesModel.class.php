<?php
/**
 * APP设备信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Model\Aums;

use Base\BaseModel;

class AppDevicesModel extends CommonModel {
    protected $trueTableName = 'au_app_devices';
    protected $connection = 'DB_AUMS';
    // protected $tablePrefix = 'au_';

    /* 自动验证规则 */
    protected $_validate = array(

    );

    /* 模型自动完成 */
    protected $_auto = array(

    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'dev_id', // 设备id
        'dev_uuid', // 移动设备的uuid
        'dev_uid', // app用户id
        'dev_jpush_id', //  极光推送id
        'dev_create_time', // 创建时间
        'dev_type', // 设备类型(1android 2ios)
        'dev_user_type', // 用户类型( 2：来拍车)
        'dev_modifytime', // 修改时间
        '_pk'=>'dev_id',
        '_type'=>array(
            'uid'=>'int',
        ),
    );

    protected $_scope = array(
    );


}

