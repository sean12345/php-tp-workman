<?php
/**
 * 车主表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Common\Model\Aums;

use Base\Model\CommonModel;

class CarOwnerModel extends CommonModel {

    protected $fields = array(
        'owner_id', // 车主编号
        'oc_id', // 线索表ID
        'uid', // 网站用户ID
        'service_id', // 预约客服编号
        'checker_id', // 评估师员工编号
        'deliver_id', // 交付顾问员工编号
        'seller_name', // 车主姓名
        'phone', // 手机号
        'car_model', // 车型
        'brand_id', // 品牌
        'series_id', // 车系
        'model_id', // 车型
        'business_status', // 业务状态(1,待预约检测 2,预约检测跟踪中 3,预约检测失败 4,待检测 5,检测成功 6,检测失败， 7,待预约签约，8,预约签约跟踪中,9,预约签约失败,10,待签约分配 11，待签约,12,签约跟踪中 13,签约失败 14签约成功 15待过户 16过户中
        'mileage', // 里程
        'first_reg_date', // 初登日期（即上牌时间）
        'status', // 状态(-1禁用，0正常）
        'comefrom', //  来源详见au_come_from表  备注：调整前  渠道来源(1，PC,2 M站)
        'comefrom_url', // 来源连接
        'location_area', // 车辆所在地
        'first_reg_city', // 上牌地点
        'service_method', // 服务方式(1,未知 2,上门 3,到店)
        'certificate_type', // 证件类型
        'certificate_number', // 有效证件号
        'province', // 省份
        'city', // 城市
        'area', // 地区
        'address', // 地址
        'next_trace_time', // 下次检测跟踪时间
        'trace_type', // 跟踪类型(0普通，1改约，2驳回，3滞留)
        'reserve_time', // 检测预约时间
        'reserve_store', // 预约门店
        'reserve_remark', // 检测预约备注(检测预约成功备注，检测预约失败备注)
        'reserve_area', // 检测预约地区
        'reserve_city', // 检测预约市
        'reserve_province', // 检测预约省
        'reserve_address', // 检测预约地址
        'is_assigned', // 是否被分配（0 未分配 1已分配）
        'assgin_remark', // 分配评估师检测备注
        'checker_name', // 评估师姓名
        'check_remark', // 检测备注
        'check_date', // 检测时间
        'check_fail_date', // 检测失败提交时间
        'sign_next_trace_time', // 签约下次跟踪时间
        'sign_service_method', // 签约服务方式(1,未知 2,上门 3,到店)
        'sign_reserve_time', // 签约预约时间
        'sign_reserve_remark', // 签约预约备注(签约预约成功备注，签约预约失败备注)
        'sign_reserve_area', // 签约预约地区
        'sign_reserve_city', // 签约预约市
        'sign_reserve_province', // 签约预约省
        'sign_reserve_address', // 签约预约地址
        'sign_reserve_store', // 签约预约门店
        'sign_assgin_remark', // 分配交付顾问签约备注
        'sign_deliver_name', // 交付顾问姓名
        'sign_check_result', // 签约结果
        'sign_date', // 签约时间
        'audit_remark', // 审核备注
        'modify_time', // 修改时间
        'posttime', // 提交时间
        'is_account_send', // 是否已发送登录账号
        'isou_id', // clcw网站的预约信息id
        'rater_id', // 定价人ID
        'is_self_upload', // 是否为评估师自主上传的车源（1是 0否）
        'remark_fail', // 检测失败备注
        'delay_status', // 检测滞留状态(1未处理，2客服处理中，3客服处理完成待再约，4再分配处理中，5调度处理完成 6预约处理中
        'check_fail_type', // 1改约2驳回3流失4退单5、调度改约
        'reserve_reminder', // 再预约提醒
        '_pk'=>'owner_id',
        '_type'=>array(
            'owner_id'=>'int',
            'oc_id'=>'int',
        ),
    );

    protected $_scope = array(
        /*正常数据*/
        'valid' => array(
            'where' => array('status' => 1), // 正常
        ),
    );

    public function test() {
        return $this->connection;
    }


}

