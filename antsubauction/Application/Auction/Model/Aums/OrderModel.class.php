<?php
/**
 * 订单信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Model\Aums;

class OrderModel extends CommonModel {
    protected $trueTableName = 'au_order';
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

        'order_id',             //  自增ID
        'order_no',             //  拍单编号
        'rank',                 //  排序(即优先级,规则：大于0的整数，数字越小越靠前)
        'emp_id',               //  创建人
        'car_id',               //  车辆编号
        'scene_id',             //  场次编号
        'status',               //  拍单状态(-1 删除,1审核中,2审核驳回,3投标中,301等待竞标,4竟标中,5待确认,7已确认,8已签约,9待过户,10过户中,11过户完成,12拍单失败,13拍单成功
        'bid_start_time',       //  投标开始时间(即上拍审核通过的时间）
        'bidding_start_time',   //  竞拍开始时间(即场次开始时间）
        'bidding_end_time',     //  竞拍结束时间(后台PHP进程更新）
        'est_elapsed_time',     //  预计拍卖耗时
        'act_elapsed_time',     //  实际拍卖耗时
        'trade_time',           //  成交时间
        'fail_type',            //  失败类型(1,车主要求重拍 2,车主不卖了(确) 3,签约失败 4,车商违约 5,过户失败 6,车主不卖了(流) 7,我方违约
        'commision',            //  交易佣金
        'transfer_fee',         //  过户费用
        'transfer_type',        //  0公司过户1车商自过
        'deliver_type',         //  交付方式
        'bid_start_price',      //  起拍价
        'bid_best_price',       //  投标阶段最高价
        'bidding_best_price',   //  竞标阶段最高价(第一名)
        'bid_best_dealer_id',   //  投标出价最高的车商ID
        'coupon',               //  可用代金券额度
        'bidding_best_dealer_id',   //  竞标出价最高的车商ID
        'company_subsidies',    //  公司补贴
        'success_price',        //  成交价格
        'success_dealer_id',    //  最终成交车商ID
        'dealer_confirm_status',    //  车商确认状态(1,待确认 2,第一名车商失败 3,第二名车商失败 4,待付款 5,付款成功)
        'is_self_confirm',      //  车主前台自助确认成交 (0 未确认 ,1已确认)
        'remark_fail',          //  失败说明            重拍说明
        'remark_reject',        //  驳回说明
        'pay_type',             //  付款方式
        'owner_confirm_service_id',     //  与车主确认的客服ID
        'dealer_confirm_service_id',    //  与车商确认的客服ID
        'unsold_service_id',            //  跟踪流拍拍单的客服ID
        'arbitrate_service_id', //  跟踪仲裁拍单的客服ID
        'is_sign_tracing',      //  是否签约跟踪
        'dealer_pay_mode',      //  车商付款方式：1、全款 2、贷款
        'dealer_pay_status',    //  车商付款状态（0未确认 ,1未付款，2，待核实 3，已付款 4 , 锁定 5,收款失败)
        'last_time',            //  最后修改时间
        'create_time',          //  创建时间
        'first_money',          //  应付首款
        'tail_money',           //  应付尾款
        'first_pay_status',     //  付首款状态(0 待付首款 1待付尾款)
        'consult_increase',     //  磋商加价（第一名加价）
        'is_consult',           //  是否来自磋商
        'reserve_price',        //  保留价
        'show_reserve_price',   //  是否显示保留价(0、不显示 1、显示)
        'is_timing_order',      //  是否为定时单
        'is_recommend',         //  是否为推荐的历史成交(1、推荐 2、取消推荐（不推荐）)
        'compensation',         //  协商补偿车商金额
        'depreciate',           //  协商车主降价
        'return_check_status',  //  回车复检状态(1:待回车,2:回车中,3:待复检,4:复检跟踪,5:车况相符,6:不符,7:协商成功)
        'check_car_status',     //  验车状态(1:待验车, 2:验车中, 3:验车成功, 4:车况不符, 5:违约)
        'is_owner_issue',       //  状态(0:不存在争议, 1:存在争议)
        'is_dealer_issue',      //  状态(0:不存在争议, 1:存在争议)
        'dealer_issue_status',  //  争议处理结果(1:待处理, 2:协商成功 3:协商失败 4、我方违约)
        'business_verify_status',   //  业务核实状态 1、业务核实（转账方式需要核实）
        '_pk'=>'order_id',
        '_type'=>array(
            'order_id'=>'int',
        ),
    );

    protected $_scope = array(
    );


}

