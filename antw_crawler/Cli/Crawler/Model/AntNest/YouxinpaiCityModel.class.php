<?php
/**
 * 优信拍车辆地址信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Crawler\Model\AntNest;

class YouxinpaiCityModel extends CommonModel {
    protected $trueTableName = 'crawler_yxp_city';
    protected $connection = 'DB_ANT_NEST';
    // protected $tablePrefix = 'ant_';

    /* 自动验证规则 */
    protected $_validate = array(

    );

    /* 模型自动完成 */
    protected $_auto = array(
        array('remark', '', self::MODEL_INSERT),
        array('createtime', 'timeNow', self::MODEL_INSERT, 'function'),
        array('updatetime', 'timeNow', self::MODEL_BOTH, 'function'),
    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'id', // 自增ID,
        'city_id', // '车系ID',
        'city_name', // '车辆所在城市名称',
        'remark', // '备注',
        'createtime', // '创建时间',
        'updatetime', // '更新时间',
        '_pk'=>'id',
        '_type'=>array(
            'id'=>'int',
        ),
    );

    protected $_scope = array(

    );


}

