<?php
/**
 * 地区信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Model\Aums;

use Base\BaseModel;

class AddrAreaModel extends CommonModel {
    protected $trueTableName = 'au_addr_area';
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
        'city_code' , // 城市编号
        'city_name', // 城市名称
        'full_name', // 全称
        'pid', // 上级ID
        'level', // 等级
        'pinyin', // 拼音
        'type', // 类型
        'order', // 排序
        'province', // 省份
        'propinyin', // 省份拼音
        '_pk'=>'city_code',
        '_type'=>array(
            'city_code'=>'int',
        ),
    );

    protected $_scope = array(
    );

}

