<?php
namespace Admin\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use Common\Org\PhpRedis;
use  Admin\Model\AntNest\MsgGatewayModel;

class YouxinpaiService extends CommonService{
    private $Redis;
    private $_youxinpaiTaskListKey = 'list_crawler_yxp_auction';
    private $_search;

    public function __construct() {
        $this->Redis = new PhpRedis();
    }

    Protected $autoCheckFields = false;

    public function crawlerTaskServiceStatus() {
        $strCommand =  'sh ' . C('CRAWLER_PATH_ROOT') . 'Sh/crawler_task_status.sh '. C('CRAWLER_PATH_ROOT');
        exec($strCommand, $res, $status);
        return $res;
    }

    public function crawlerTaskServiceStart() {
        $res = false;
        $strCommand = 'sh ' . C('CRAWLER_PATH_ROOT') . 'Sh/crawler_task_start.sh '. C('CRAWLER_PATH_ROOT');
        exec($strCommand, $resStart, $statusStart);
        if ($status == 0) {
                $res = true;
        }
        return $res;
    }

    public function crawlerTaskServiceStop() {
        $res = false;
        $strCommand =  'sh ' . C('CRAWLER_PATH_ROOT') . 'Sh/crawler_task_stop.sh '. C('CRAWLER_PATH_ROOT');
        exec($strCommand, $res, $status);
        if ($status == 0) {
                $res = true;
        }
        return $res;
    }

    /**
     * 获取优信拍抓取数据总量
     *
     * @return mix
     */
    public function getAuctionCount()
    {
        $modelObj = D('AntNest\YouxinpaiAuction', 'Model');
        $res = $modelObj->count();
        return $res;
    }

    /**
     * 获取优信拍抓取数据总量（已完成交易的）
     *
     * @return mix
     */
    public function getAuctionCountHasTradePrice()
    {
        $modelObj = D('AntNest\YouxinpaiAuction', 'Model');
        $condition = array(
            'resp_code' => array('in', '-15, -12, -3')
        );
        $res = $modelObj->where($condition)->count();
        return $res;
    }

    /**
     * 获取24小时内优信拍抓取数据总量
     *
     * @param  string $bgnTime [description]
     * @param  string $endTime [description]
     * 
     * @return mix
     */
    public function getAuctionCountByTime($bgnTime='', $endTime='')
    {
        $res = array();
        $condition = array();
        if ($bgnTime > 0 && $endTime > 0) {
            $condition['createtime'] = array(
                                                        array('EGT', $bgnTime),
                                                        array('ELT', $endTime),
                                                        );
        } elseif ($bgnTime > 0) {
            $condition['createtime'] = array('EGT', $bgnTime);
        } elseif ($endTime > 0) {
            $condition['createtime'] = array('ELT', $endTime);
        }
        $modelObj = D('AntNest\YouxinpaiAuction', 'Model');
        $res = $modelObj->where($condition)->count();
        return $res;
    }

    /**
     * 获取24小时内优信拍抓取数据总量（已完成交易的）
     *
     * @param  string $bgnTime [description]
     * @param  string $endTime [description]
     * 
     * @return mix
     */
    public function getAuctionCountHasTradePriceByTime($bgnTime='', $endTime='')
    {
        $res = array();
        $condition = array();
        if ($bgnTime > 0 && $endTime > 0) {
            $condition['createtime'] = array(
                                                        array('EGT', $bgnTime),
                                                        array('ELT', $endTime),
                                                        );
        } elseif ($bgnTime > 0) {
            $condition['createtime'] = array('EGT', $bgnTime);
        } elseif ($endTime > 0) {
            $condition['createtime'] = array('ELT', $endTime);
        }
        $modelObj = D('AntNest\YouxinpaiAuction', 'Model');
        $condition['resp_code'] = array('in', '-15, -12, -3');
        $res = $modelObj->where($condition)->count();
        return $res;
    }

    /**
     * 获取优信拍车辆拍卖情况列表
     *
     * @param  array $condtion 
     * @param  int $pageNum
     * @param  int $perPage
     * 
     * @return mix
     */
    public function getCarListByPagination($condition = array(), $pageNum = 1, $perPage = 15)
    {
        $res = array();
        $cond = array();
        if ($condition['bgnTime'] > 0 && $condition['endTime'] > 0) {
            $cond['createtime'] = array(
                                                        array('EGT', $condition['bgnTime']),
                                                        array('ELT', $condition['endTime']),
                                                        );
        } elseif ($condition['bgnTime'] > 0) {
            $cond['createtime'] = array('EGT', $bgnTime);
        } elseif ($condition['endTime'] > 0) {
            $cond['createtime'] = array('ELT', $condition['endTime']);
        }
        if (!empty($condition['resp_code'])) $cond['au.resp_code'] = $condition['resp_code'];
        if (!empty($condition['car_city_id'])) $cond['c.car_city_id'] = $condition['car_city_id'];
        if (!empty($condition['master_brand_id'])) $cond['c.master_brand_id'] = $condition['master_brand_id'];
        if (!empty($condition['brand_id'])) $cond['c.brand_id'] = $condition['brand_id'];
        if (!empty($condition['search_keyword'])) $cond['c.car_name'] = array('like', '%' . $condition['search_keyword'] . '%');
        $modelObj = D('AntNest\YouxinpaiCar', 'Model');
        $res = $modelObj->join(' c left join crawler_yxp_auction au on au.publish_id = c.publish_id')
                                     ->field('c.*,au.publish_type,au.publish_type,au.hprice,au.total_price,au.trade_price,au.buyer_agent_fee,au.buyer_trade_fee,au.resp_code,au.is_start_auction,au.Is_over_reser,au.remark,au.updatetime as tradetime,au.createtime as crawlertime')
                                     ->where($cond)
                                     ->page($pageNum . ',' . $perPage)
                                     ->order('carsource_id desc')
                                     ->select();
        // $sql = $modelObj->getLastSql();
        return $res;
    }

    /**
     * 获取优信拍车辆拍卖情况列表结果集总数
     *
     * @param  array $condtion
     * 
     * @return mix
     */
    public function getCarCount($condition = array())
    {
        $res = array();
        $cond = array();     
        if ($condition['bgnTime'] > 0 && $condition['endTime'] > 0) {
            $cond['createtime'] = array(
                                                        array('EGT', $condition['bgnTime']),
                                                        array('ELT', $condition['endTime']),
                                                        );
        } elseif ($condition['bgnTime'] > 0) {
            $cond['createtime'] = array('EGT', $bgnTime);
        } elseif ($condition['endTime'] > 0) {
            $cond['createtime'] = array('ELT', $condition['endTime']);
        }
        if (!empty($condition['resp_code'])) $cond['resp_code'] = $condition['resp_code'];
        if (!empty($condition['car_city_id'])) $cond['c.car_city_id'] = $condition['car_city_id'];
        if (!empty($condition['master_brand_id'])) $cond['c.master_brand_id'] = $condition['master_brand_id'];
        if (!empty($condition['brand_id'])) $cond['c.brand_id'] = $condition['brand_id'];
        if (!empty($condition['search_keyword'])) $cond['c.car_name'] = array('like', '%' . $condition['search_keyword'] . '%');
        $modelObj = D('AntNest\YouxinpaiCar', 'Model');
        // $res = $modelObj->relation('Auction')->where($cond)->page($pageNum . ',' . $perPage)->order('carsource_id desc')->count();

        $res = $modelObj->join(' c left join crawler_yxp_auction au on au.publish_id = c.publish_id')
                                     ->where($cond)
                                     ->count();

        return $res;
    }

    /**
     * 获取优信拍车辆所在城市选项列表
     * 
     * @return mix
     */
    public function getAddrOptionList()
    {
        $res = array();
        // $modelObj = D('AntNest\YouxinpaiCity', 'Model');
        // $res = $modelObj->field('id,city_id,city_name,createtime')
        //                              ->select();
        $modelObj = D('AntNest\YouxinpaiCar', 'Model');
        $res = $modelObj->join(' c inner join crawler_yxp_city ct on ct.city_id = c.car_city_id')
                                     ->field('ct.id,ct.city_id,ct.city_name,ct.createtime,count(c.car_city_id) as city_car_count')
                                     ->group('c.car_city_id')
                                     ->order('ct.id asc')
                                     ->select();
        return $res;
    }

    /**
     * 获取优信拍车辆主品牌选项列表
     * 
     * @return mix
     */
    public function getMasterBrandOptionList()
    {
        $res = array();
        // $modelObj = D('AntNest\YouxinpaiCity', 'Model');
        // $res = $modelObj->field('id,city_id,city_name,createtime')
        //                              ->select();
        $modelObj = D('AntNest\YouxinpaiCar', 'Model');
        $res = $modelObj->join(' c inner join crawler_yxp_master_brand mb on mb.master_brand_id = c.master_brand_id')
                                     ->field('mb.id, mb.master_brand_id, mb.master_brand_letter, mb.master_brand_name, mb.createtime, count(c.master_brand_id) as master_brand_car_count')
                                     ->group('c.master_brand_id')
                                     ->order('mb.master_brand_letter asc')
                                     ->select();
        return $res;
    }

    /**
     * 获取优信拍车辆车系选项列表
     *
     * @param int $masterBrandID
     * 
     * @return mix
     */
    public function getBrandOptionList($masterBrandID='')
    {
        $res = array();
        // $modelObj = D('AntNest\YouxinpaiCity', 'Model');
        // $res = $modelObj->field('id,city_id,city_name,createtime')
        //                              ->select();
        $cond = array(
            'b.master_brand_id' => $masterBrandID
        );
        $modelObj = D('AntNest\YouxinpaiBrand', 'Model');
        $res = $modelObj->join(' b inner join crawler_yxp_car c on b.brand_id = c.brand_id')
                                     ->field('b.id, b.brand_id, b.master_brand_id, b.brand_name, b.createtime')
                                     ->group('b.brand_id')
                                     ->order('brand_id asc')
                                     ->where($cond)
                                     ->select();
        return $res;
    }

}