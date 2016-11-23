<?php
/**
 * 车商订阅类型信息表
 *
 * @category Model
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Auction\Model\Aums;

class SubscribeKeyModel extends CommonModel {
    protected $trueTableName = 'au_subscribe_key';
    protected $connection = 'DB_AUMS';
    // protected $tablePrefix = 'au_';

    const SEND_SUCCESS = 0; // 短信发送成功
    const SEND_FAILD = 1; // 短信发送失败

    /* 自动验证规则 */
    protected $_validate = array(

    );

    /* 模型自动完成 */
    protected $_auto = array(
        array('createtime', 'timeNow', self::MODEL_INSERT, 'function'),
    );

    //'数据表字段'=>'表单字段'
    protected $_map = array(
    );

    protected $fields = array(
        'key_id' , //  订阅类型ID (自增)
        'key_name', // 名称,
        'key_type', // 类型,
        'dealer_id', // 车商ID,
        'sid', // 订阅ID,
        'createtime', // '创建时间',
        '_pk'=>'key_id',
        '_type'=>array(
            'key_id'=>'int',
        ),
    );

    protected $_scope = array(
    );

    /**
     * 获取订阅器条件数据
     * @param string $series 车系
     * @param string $regCity 所在地
     * @param string $plate 注册地
     * @param string $regDate 注册日期
     * @param $emission 排量
     * @return array
     */
    public function getSubscribeList($series = '', $regCity = '', $plate = '', $regDate = '', $emission)
    {
        if (!empty($plate[1])){
            $nPlate = $plate[0] . $plate[1][0];
        } else {
            $nPlate = $plate[0];
        }
        $age = diffDate($regDate, strtotime('Y-m-d H:i:s'));
        $condition = "(`key_type` = 2 AND ( `key_name` = '{$series}'' OR `key_name` = -1 )) OR 
        (`key_type` = 3 AND ( `key_name` = '{$nPlate}' OR key_name = -1 )) OR 
        (`key_type` = 4 AND ( `key_name` = '{$regCity}' OR `key_name` = -1 )) OR 
        (`key_type` = 5 AND ( `key_name` = '{$age}' OR `key_name` = -1 )) OR 
        (`key_type` = 6 AND ( `key_name` = '{$emission}' OR `key_name` = -1 ))";
        return $this->field('key_id,key_type,uid,dealer_id,sid')->where($condition)->select();
    }


}

