<?php
/**
 * 优信拍拍单数据信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Admin\Model\AntNest;

class YouxinpaiCarModel extends CommonModel {
    protected $trueTableName = 'crawler_yxp_car';
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
        'publish_id', // '拍单ID',
        'carsource_id', // '拍车车辆ID'
        'car_name', // '车辆名称'
        'car_original_color', // '车辆颜色'
        'car_type_id', // '车辆类型ID'
        'car_type_name', // '车辆类型名称'
        'car_usetype', // '车辆应用类型'
        'conditions_remark', // '问题备注'
        'coolingcheck_remark', // '冷却系统检测'
        'effluent_yellow', // '排放标准'
        'is_firsthand', // '是否一手车'
        'master_brand_id', // '主品牌ID'
        'master_brand_name', // '主品牌名称'
        'mileage', // '公里数'
        'newcar_warranty', // '新车担保'
        'carshiptax_expiredate', // '保险到期日'
        'paint_repair', // '表面修复'
        'present_status', // '表面状况'
        'is_watercar', // '是否过水车'
        'regist_date', // '注册时间'
        'license_number', // '牌照'
        'license_date', // '上牌时间'
        'summary', // '车辆描述'
        'condition_grade', // '车况评级'
        'brand_id', // '品牌ID'
        'brand_name', // '品牌名称'
        'car_city', // '车辆所在城市'
        'car_configinfo', // '短信网关名称'
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

