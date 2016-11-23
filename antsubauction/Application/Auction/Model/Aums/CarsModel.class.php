<?php
/**
 * 车辆信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Model\Aums;

class CarsModel extends CommonModel {
    protected $trueTableName = 'au_cars';
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

        'car_id' , //  自增ID
        'car_no',           //  车辆编号
        'mbrand_id',        //  主品牌id
        'brand_id',         //  品牌id
        'series_id',        //  车系id
        'model_id',         //  车型id
        'custom_model',     //  自定义车型（pad端用）
        'owner_id',         //  车主编号
        'car_status',       //  车辆状态(-1删除,1 待审核,2 审核失败,3 审核驳回,4 待拍卖,5 拍卖中,6 流拍,7 待重拍, 8 交易失败, 9 交易成功)
        'remark',           //  备注（审核失败，驳回原因）
        'modify_time',      //  最后修改时间
        'posttime',         //  提交时间
        'first_reg_date',   //  初登日期 也即 首次上牌
        'composite_state',  //  车辆综合状况(95,80,65,50,35)
        'accident_level',   //  车辆事故等级(A,B,C,D)
        'history_state',    //  车辆历史状况（1火烧车，2水泡车）
        'pointer_mileage',  //  表显里程
        'ex_factory_date',  //  出厂日期
        'reg_city',         //  车辆注册地
        'reg_area',         //  车辆注册区
        'emission',         //  车辆排放标准
        'car_cc',           //  排量
        'turbo',            //  是否是涡轮增压
        'gearbox',          //  变速箱
        'drive_method',     //  驱动方式
        'fuel_type',        //  燃油类型
        'car_color',        //  颜色
        'engine_no',        //  发动机号
        'cur_use_type',     //  现使用方式
        'use_properties',   //  使用性质
        'location_area',    //  车辆所在地
        'transfer_limit',   //  过户限制(1 必须过本地,2 必须过外户,3 不限制)
        'vin',              //  车架号
        'plate_prefix',     //  牌照号码
        'plate_suffix',     //  牌照号码后缀
        'au_times',         //  拍卖次数
        'unsold_times',     //  流拍次数
        'bid_best_price',   //  出价最高价            针对此车所有投标、竟标的最高价格
        'suggest_max_price',//  建议最高价
        'suggest_min_price',//  建议最低价
        'price_emp_id',     //  定价人ID
        'price_time',       //  定价时间
        'reserve_price',    //  保留价即意向价格
        'show_reserve_price',   //  是否显示保留价(0、不显示 1、显示)
        'is_proto_uploaded',    //  是否已上传签拍协议
        'view',             //  浏览次数
        'carrying_num',     //  核定载客数
        'tyre_type',        //  轮胎规格
        'is_imported',      //  是否进口
        'transfer_times',   //  过户次数
        'brand_model',      //  品牌型号 即厂牌型号
        'get_method',       //  获得方式
        'car_type',         //  车辆类型
        're_auction_type',  //  重拍类型(1,未过保留价 2,车商违约 3、磋商失败，报告提交96小时内可重拍)
        're_auction_reason',    //  重拍原因
        'success_price',    //  成交价
        'first_money',      //  已付首款
        'reserve_price_history',    //  保留价修改历史
        'mot',              //  年检情况(1,有效期内 2,已过有效期)
        'car_source',       //  车辆来源(1,4S店 2,个人)
        'peccancy',         //  违章情况(1,无 2,有)
        'three_in_one',     //  三证合一(1,是 2,否)
        'tail_money',       //  已付尾款
        'pay_status',       //  付款状态：-1 付款关闭 1、待付首款 2、已付首款 3、待付尾款 4、已付尾款
        'bid_up_price',     //  抬价总额
        'cut_down_price',   //  砍价总额
        'is_game_over',     //  抬（砍）价活动是否结束
        'bargain_limit',    //  抬（砍）价限额
        'bargain_price_min',    //  抬（砍）价随机最小值
        'bargain_price_max',    //  抬（砍）价随机最大值
        'audit_emp_id',     //  审核人ID
        'audit_time',       //  车辆检测审核时间(第一次)
        'damage_pics',      //  损伤图
        'deal_type',        //  成交类型0正常成交1其他渠道成交
        'fail_type',        //  失败类型(1车主不卖2退车)
        'is_dealer_breach', //  是否车商违约(0否1是)
        'delivery_mode',    //  交付模式(1先付款后验车,2先验车后付款)
        'is_valid',         //  检测报告是否有效(1有效0无效)
        'check_fee',        //  车辆检测费用
        '_pk'=>'car_id',
        '_type'=>array(
            'car_id'=>'int',
        ),
    );

    protected $_scope = array(
    );


}

