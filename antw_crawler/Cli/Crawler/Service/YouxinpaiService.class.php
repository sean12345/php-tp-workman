<?php
/**
 * 优信拍数据抓取业务模型类
 * 
 */
namespace Crawler\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use \Common\Org\PhpRedis;
use \Common\Org\Request;

class YouxinpaiService extends BaseService{
    private $Redis;
    private $_youxinpaiTaskListKey = 'list_crawler_yxp_auction';

    Protected $autoCheckFields = false;

    public function __construct() {
        $this->Redis = new PhpRedis();
    }

    /**
     * 添加优信拍拍单数据抓取任务     
     *
     * （任务生产者）
     *
     * @param  string  $mobile  短信接收人电话
     * @param  int  $number  短信自定义类型
     * @param  array  $msgTplParams  短信模块参数
     * 
     * @return index
     */
    public function addCrawlerTask()
    {
        $auctionList = $this->getAuctionList();
        if (!empty($auctionList)) {
            foreach ($auctionList as $item) {
                $taskContent = array(
                                                   'auction_id' => !empty($item['PublishID']) ? $item['PublishID'] : '',
                                                   'carsource_id' => !empty($item['CarSourceId']) ? $item['CarSourceId'] : '',
                                                   'request_time' => timeNow(),
                                                   );
                $taskContent = json_encode($taskContent);
                $res = $this->Redis->lPush($this->_youxinpaiTaskListKey, $taskContent);
            }
        }
        return $res;
    }

    /**
     * 抓取优信拍交易大厅拍单列表数据
     *
     * 从拍单列表数据中抽取拍单ID和车辆ID, 将该信息推入拍单详情和车辆详情抓取任务队列
     *
     * @return index
     */
    public function getAuctionList()
    {
        $requestObj = new Request();
        $apiUrl = 'http://i.youxinpai.com/AjaxObjectPage/ListForEveryAuctionList.ashx?list=&t=2&tvaid=0&cid=0&d=600';
        $isPost =  1;
        $params = array(
            'list' => '',
            't' => 2,
            'cid' => 0,
            'tvaid' => 0,
            'd' => 600,
        );
        $headers = array(
            "content-type: application/x-www-form-urlencoded; charset=UTF-8",
        );
        $res = $requestObj->juhecurl($apiUrl, $headers,  $params, $isPost);
        $res = json_decode($res, true);
        return $res;
    }


    /**
     * 获取优信拍数据抓取任务量
     *
     * @return mix
     */
    public function getTaskCount()
    {
        try {
            $this->Redis->ping();
        } catch (\Exception $e) {
            $this->Redis = new PhpRedis();
        }
        $res = $this->Redis->lLen($this->_youxinpaiTaskListKey);
        return $res;
    }

    /**
     * 处理拍单详情和车辆详情抓取任务
     *
     * 根据任务详情中的拍单ID和车辆ID, 将抓取到的拍单详情和车辆详情信息入库
     *
     * (任务消费者)
     *
     * @return mix
     */
    public function checkoutCrawlerTask()
    {
        $res = false;
        $taskContent = $this->Redis->rPop($this->_youxinpaiTaskListKey);
        $taskContent = json_decode($taskContent, true);
        if ($taskContent) {
            $auctionInfoCrawed = $this->getAuctionInfoByAuctionID($taskContent['auction_id']); 
            if (!$auctionInfoCrawed) {
                $auctionInfo = $this->getAuctionInfoFromYXP($taskContent['auction_id']);
                if (!empty($auctionInfo)) {
                    $auctionInfo['publishID'] = $taskContent['auction_id'];
                    $resAuctionAdd =  $this->addAuctionInfo($auctionInfo);
                }
                $carInfo = $this->getCarsourceInfoFromYXP($taskContent['auction_id'], $taskContent['carsource_id']);
                if (!empty($carInfo)) {
                    $carInfo['publishID'] = $taskContent['auction_id'];
                    $carInfo['CarSourceId'] = $taskContent['carsource_id'];
                    $resCarAdd =  $this->addCarInfo($carInfo);
                }
                if ($resAuctionAdd && $resCarAdd) {
                    $res = true;
                }
            }
        }
        return $res;
    }

    /**
     * 获取优信拍拍单数据
     *
     * @param int $publishID 拍单ID
     * @return mix
     */
    public function getAuctionInfoFromYXP($publishID='')
    {
        $requestObj = new Request();
        $apiUrl = 'http://i.youxinpai.com/AjaxObjectPage/GetInfoForClient.ashx';
        $isPost =  1;
        $params = array(
            'Op' => 'ts',
            'publishId' => $publishID,
            'CurrTvaId' => 0,
            'span' => 674,
        );
        $headers = array(
            "content-type: application/x-www-form-urlencoded; charset=UTF-8",            
        );
        $res = $requestObj->juhecurl($apiUrl, $headers,  $params, $isPost);
        $res = json_decode($res, true);
        return $res;
    }

    /**
     * 获取优信拍拍单车辆数据
     *
     * @param int $publishID 拍单ID
     * @param int $carsourceID 车辆ID
     * @return mix
     */
    public function getCarsourceInfoFromYXP($publishID='', $carsourceID='')
    {
        $requestObj = new Request();
        $apiUrl = 'http://i.youxinpai.com/Ajax/AjaxHelper.ashx';
        $isPost =  0;
        $params = array(
            'publishId' => $publishID,
            'carSourceId' => $carsourceID,
            'huoyanId' => 0,
            'tvaid' => 0,
        );
        $headers = array(
            "content-type: application/x-www-form-urlencoded; charset=UTF-8",
            "Referer: http://i.youxinpai.com/auctionhall/listforeveryone.aspx"   
        );
        $res = $requestObj->juhecurl($apiUrl, $headers,  $params, $isPost);
        $res = json_decode($res, true);
        return $res;
    }

    /**
     * 获取优信拍拍单最终成交价
     *
     * @return mix
     */
    public function crawlerTradePrice()
    {
        $publishIds = $this->getUntradeAuctionIds();
        if (!empty($publishIds)) {
            foreach ($publishIds as $item) {
                $publishID = $item['publish_id'];
                $auctionInfo = $this->getAuctionInfoFromYXP($publishID);
                $data = array();
                if (!empty($auctionInfo) && $auctionInfo['tradePrice'] > 0 && in_array($auctionInfo['RespCode'], array('-15', '-3'))) {
                    if ($auctionInfo['totalPrice']) {
                        $data['total_price'] = $auctionInfo['totalPrice'] * 10000;   
                    } else {
                        $data['total_price'] = $auctionInfo['tradePrice'] * 10000 +  $auctionInfo['BuyerAgentFee'] + $auctionInfo['BuyerTradeFee'];
                    }
                    // if ($auctionInfo['totalPrice']) $data['total_price'] = $auctionInfo['totalPrice'] * 10000;
                    if ($auctionInfo['tradePrice']) $data['trade_price'] = $auctionInfo['tradePrice'] * 10000;
                    if ($auctionInfo['hprice']) $data['hprice'] = $auctionInfo['HPrice'] * 10000;
                    if ($auctionInfo['BuyerAgentFee']) $data['buyer_agent_fee'] = $auctionInfo['BuyerAgentFee'];
                    if ($auctionInfo['BuyerTradeFee']) $data['buyer_trade_fee'] = $auctionInfo['BuyerTradeFee'];
                    if ($auctionInfo['RespCode']) $data['resp_code'] = $auctionInfo['RespCode'];
                    if ($auctionInfo['IsStartAuction']) $data['is_start_auction'] = $auctionInfo['IsStartAuction'];
                    if ($auctionInfo['IsOverReser']) $data['Is_over_reser'] = $auctionInfo['IsOverReser'];
                }
                $res = $this->saveAuctionInfoByPublishID($publishID, $data);
            }
        }
        return $res;
    }

    /**
     * 获取优信拍未成交拍单ID列表
     *
     * @return mix
     */
    public function getUntradeAuctionIds()
    {
        $condition = array(
            'resp_code' => array('not in','-15, -3')
        );
        $modelObj = D('AntNest\YouxinpaiAuction', 'Model')->db(3, C('DB_ANT_NEST'), true);
        $res = $modelObj->where($condition)->field('publish_id')->select();
        return $res;
    }

    /**
     * 按照拍单ID获取优信拍拍单数据
     *
     * @param int $auctionID
     * 
     * @return mix
     */
    public function getAuctionInfoByAuctionID($auctionID = '')
    {
        $condition = array(
            'publish_id' => $auctionID
        );
        $modelObj = D('AntNest\YouxinpaiAuction', 'Model')->db(3, C('DB_ANT_NEST'), true);
        $res = $modelObj->where($condition)->find();
        return $res;
    }

    /**
     * 按照拍单ID和carSourceID获取优信拍拍单车辆数据
     *
     * @param int $auctionID
     * @param int $carSourceID
     * 
     * @return mix
     */
    public function getCarSourceInfo($auctionID = '', $carSourceID = '')
    {
        $condition = array(
            'publish_id' => $auctionID,
            'carsource_id' => $carSourceID,
        );
        $modelObj = D('AntNest\YouxinpaiCar', 'Model')->db(3, C('DB_ANT_NEST'), true);
        $res = $modelObj->where($condition)->find();
        return $res;
    }

    /**
     * 添加优信拍拍单数据
     *
     * @param array $params 
     * @return mix
     */
    public function addAuctionInfo($params=array())
    {
        $data = array(
            'publish_id' => $params['publishID'],
            'publish_type' => !empty($params['PublishType']) ? $params['PublishType'] : '',
            'hprice' => !empty($params['HPrice']) ? $params['HPrice'] * 10000 : 0,
            'total_price' => !empty($params['totalPrice']) ? $params['totalPrice'] * 10000 : 0,
            'trade_price' => !empty($params['tradePrice']) ? $params['tradePrice'] * 10000 : 0,
            'buyer_agent_fee' => $params['BuyerAgentFee'],
            'buyer_trade_fee' => $params['BuyerTradeFee'],
            'resp_code' => $params['RespCode'],
            'is_start_auction' => $params['IsStartAuction'],
            'Is_over_reser' => $params['IsOverReser'],
            'createtime' => timeNow(),
        );
        $modelObj = D('AntNest\YouxinpaiAuction', 'Model')->db(3, C('DB_ANT_NEST'), true);
        $res = $modelObj->data($data)->add();
        return $res;
    }

    /**
     * 修改优信拍拍单数据
     *
     * @param int  $publishID 
     * @param array $params 
     * @return mix
     */
    public function saveAuctionInfoByPublishID($publishID='', $params=array())
    {
        $data = array(
            'updatetime' => timeNow(),
        );
        if (!empty($params['publish_type'])) $data['publish_type'] = $params['publish_type'];
        if (!empty($params['hprice'])) $data['hprice'] = $params['hprice'];
        if (!empty($params['total_price'])) $data['total_price'] = $params['total_price'];
        if (!empty($params['trade_price'])) $data['trade_price'] = $params['trade_price'];
        if (!empty($params['buyer_agent_fee'])) $data['buyer_agent_fee'] = $params['buyer_agent_fee'];
        if (!empty($params['buyer_trade_fee'])) $data['buyer_trade_fee'] = $params['buyer_trade_fee'];
        if (!empty($params['resp_code'])) $data['resp_code'] = $params['resp_code'];
        if (!empty($params['is_start_auction'])) $data['is_start_auction'] = $params['is_start_auction'];
        if (!empty($params['Is_over_reser'])) $data['Is_over_reser'] = $params['Is_over_reser'];
        $condition = array(
            'publish_id' => $publishID
        );
        $modelObj = D('AntNest\YouxinpaiAuction', 'Model')->db(3, C('DB_ANT_NEST'), true);
        $res = $modelObj->where($condition)->data($data)->save();
        return $res;
    }

    /**
     * 添加优信拍拍单车辆数据
     *
     * @param array $params
     * @return mix
     */
    public function addCarInfo($params=array())
    {
        $data = array(
            'publish_id' => $params['publishID'],
            'carsource_id' => $params['CarSourceId'],
            'car_name' => !empty($params['Detail']['CarName']) ? $params['Detail']['CarName'] : '',
            'car_original_color' => !empty($params['originalColor']) ? $params['originalColor'] : '',
            'car_type_id' => !empty($params['Detail']['CarTypeId']) ? $params['Detail']['CarTypeId'] : '',
            'car_type_name' => !empty($params['Detail']['CarTypeName']) ? $params['Detail']['CarTypeName'] : '',
            'car_usetype' => !empty($params['Detail']['CarUseType']) ? $params['Detail']['CarUseType'] : '',
            'conditions_remark' => !empty($params['Detail']['ConditionsRemark']) ? $params['Detail']['ConditionsRemark'] : '',
            'coolingcheck_remark' => !empty($params['Detail']['CoolingCheckRemark']) ? $params['Detail']['CoolingCheckRemark'] : '',
            'effluent_yellow' => !empty($params['Detail']['EffluentYellow']) ? $params['Detail']['EffluentYellow'] : '',
            'is_firsthand' => !empty($params['Detail']['IsFirstHand']) ? $params['Detail']['IsFirstHand'] : '',
            'master_brand_id' => !empty($params['Detail']['MasterBrandId']) ? $params['Detail']['MasterBrandId'] : '',
            'master_brand_name' => !empty($params['Detail']['MasterBrandName']) ? $params['Detail']['MasterBrandName'] : '',
            'mileage' => !empty($params['Detail']['Mileage']) ? $params['Detail']['Mileage'] : '',
            'newcar_warranty' => !empty($params['Detail']['NewCarWarranty']) ? $params['Detail']['NewCarWarranty'] : '',
            'carshiptax_expiredate' => !empty($params['Detail']['CarShipTaxExpireDate']) ? $params['Detail']['CarShipTaxExpireDate'] : '',
            'paint_repair' => !empty($params['Detail']['PaintRepair']) ? $params['Detail']['PaintRepair'] : '',
            'present_status' => !empty($params['Detail']['PresentStatus']) ? $params['Detail']['PresentStatus'] : '',
            'is_watercar' => !empty($params['Detail']['isWaterCar']) ? $params['Detail']['isWaterCar'] : '',
            'regist_date' => !empty($params['Detail']['RegistDate']) ? $params['Detail']['RegistDate'] : '',
            'license_number' => !empty($params['Detail']['LicenseNumber']) ? $params['Detail']['LicenseNumber'] : '',
            'license_date' => !empty($params['Detail']['LicenseDate']) ? $params['Detail']['LicenseDate'] : '',
            'summary' => !empty($params['Summary']) ? json_encode($params['Summary']): '',
            'condition_grade' => !empty($params['ConditionGrade']) ? $params['ConditionGrade'] : '',
            'brand_id' => !empty($params['Detail']['BrandId']) ? $params['Detail']['BrandId'] : '',
            'brand_name' => !empty($params['Detail']['BrandName']) ? $params['Detail']['BrandName'] : '',
            'car_city' => !empty($params['Detail']['CarCity']) ? $params['Detail']['CarCity'] : '',
            'car_configinfo' => !empty($params['Detail']['PublishType']) ? $params['Detail']['PublishType'] : '',
            'createtime' => timeNow(),
        );
        if (!empty($params['Detail']['CarCity'])) {
            $cityInfo = $this->getCityInfoByName($params['Detail']['CarCity']);
            if (!empty($cityInfo['city_id'])) {
                $data['car_city_id'] = $cityInfo['city_id'];
            }
        }
        $modelObj = D('AntNest\YouxinpaiCar', 'Model')->db(3, C('DB_ANT_NEST'), true);
        $res = $modelObj->data($data)->add();
        return $res;
    }

    /**
     * 获取城市信息
     * 
     * @param int $cityName
     * @return mix
     */
    public function getCityInfoByName($cityName = '') {
        $res = array();
        $modelObj = D('AntNest\YouxinpaiCity', 'Model')->db(3, C('DB_ANT_NEST'), true);
        $cond = array(
            'city_name' => $cityName
        );
        $res = $modelObj->where($cond)->field('id,city_id,city_name,createtime')->find();
        return $res;
    }

    /**
     * 添加优信拍拍单车辆主品牌
     *
     * @param array $params
     * @return mix
     */
    public function addMasterBrand($params=array())
    {
        $data = array(
            'master_brand_id' => $params['master_brand_id'],
            'master_brand_letter' => $params['master_brand_letter'],
            'master_brand_name' => $params['master_brand_name'],
            'createtime' => timeNow(),
        );
        $modelObj = D('AntNest\YouxinpaiMasterBrand', 'Model')->db(3, C('DB_ANT_NEST'), true);
        $res = $modelObj->data($data)->add();
        return $res;
    }

    /**
     * 添加优信拍拍单车辆品牌车系
     *
     * @param array $params
     * @return mix
     */
    public function addBrand($params=array())
    {
        $data = array(
            'brand_id' => $params['brand_id'],
            'master_brand_id' => $params['master_brand_id'],
            'brand_name' => $params['brand_name'],
            'createtime' => timeNow(),
        );
        $modelObj = D('AntNest\YouxinpaiBrand', 'Model')->db(3, C('DB_ANT_NEST'), true);
        $res = $modelObj->data($data)->add();
        return $res;
    }

}