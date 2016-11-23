<?php
/**
 * 车系信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Model\Aums;

use Base\BaseModel;

class CarSeriesModel extends CommonModel {
    protected $trueTableName = 'au_car_series';
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
        'series_id' , // 车系ID
        'brand_id', // 品牌id
        'name', // 车系名称
        'type', // 车系类型(1微型车,2小型车,3中型车,4中大型车,5面包车,6卡车,7概念车,8SUV,9MPV,10跑车,11紧凑型车,12客车,13皮卡,14豪华车,15其它)
        'describe', // 详细描述
        'sale_status', // 销售状态(1,在销，2,停销 3,待查)
        'spell', // 拼音
        'status', // 状态（-1,删除 0,启用 1,禁用)
        'update_time', //  更新时间
        '_pk'=>'series_id',
        '_type'=>array(
            'series_id'=>'int',
        ),
    );

    protected $_scope = array(
    );

}

