<?php
/**
 * 车辆品牌表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Model\Aums;

use Base\BaseModel;

class CarBrandModel extends CommonModel {
    protected $trueTableName = 'au_car_brand';
    protected $connection = 'DB_AUMS';
    // protected $tablePrefix = 'au_';

    const STATUS_DELETE = -1;
    const STATUS_DISABLE = 1;
    const STATUS_ENABLED = 0;

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

        'brand_id',         //  自增ID
        'mbrand_id',        //  主品牌id
        'manufacturer_id',  //  厂商编号
        'name',             //  品牌名称
        'country',          //  国家
        'first_char',       //  首字母
        'spell',            //  全拼
        'status',           //  状态（-1,删除 0,启用 1,禁用)
        'update_time',
        '_pk'=>'brand_id',
        '_type'=>array(
            'brand_id'=>'int',
        ),
    );

    protected $_scope = array(
    );


}

