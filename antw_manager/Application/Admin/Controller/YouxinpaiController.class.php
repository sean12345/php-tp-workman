<?php
/**
 * ant-weaver服务管理平台
 *
 * 优信拍数据抓取服务管理
 *
 *
 * @category API
 * @version v1.0
 * @license (http://www.clcw.com.cn/licenses/LICENSE-2.0)
 * @copyright (c) 2016-2026 http://www.clcw.com.cn All rights reserved.
 */
namespace Admin\Controller;

use Base\ExceptionHandler;
use Base\BaseModel;

class YouxinpaiController extends CommonController {

    /**
     * 获取车辆列表
     *      
     * @return [type] [description]
     */
    public function productSearch() {
        $this->isLogin();
        $youxinpaiObj = D('Youxinpai', 'Service');
        $cityOptionList = $youxinpaiObj->getAddrOptionList();
        $masterBrandOptionList = $youxinpaiObj->getMasterBrandOptionList();
        $condition = array();
        $pageNum = I('get.page_num', 1);
        $perPage = I('get.per_page', 15);
        $carList = $youxinpaiObj->getCarListByPagination($condition, $pageNum, $perPage);
// var_dump($carList);        
        $rowCount = $youxinpaiObj->getCarCount($condition);
        if (IS_AJAX) {
            $this->returnResponse($carList);
        } else {
            $this->assign('city_option_list', $cityOptionList); // 城市选项列表
            $this->assign('master_brand_option_list', $masterBrandOptionList); // 主品牌选项列表
            $this->assign('page_num', $pageNum); // 当前页
            $this->assign('row_count', $rowCount); // 结果记录总数
            $this->assign('car_list', $carList); // 车商列表
            $this->display('cars');
        }
    }

    /**
     * ajax获取车辆列表
     *      
     * @return [type] [description]
     */
    public function ajaxProductSearch() {
        $this->isLogin();
        $youxinpaiObj = D('Youxinpai', 'Service');
        $condition = array();
        if (I('get.resp_code')) $condition['resp_code'] = I('get.resp_code');
        if (I('get.car_city_id')) $condition['car_city_id'] = I('get.car_city_id');
        if (I('get.master_brand_id')) $condition['master_brand_id'] = I('get.master_brand_id');
        if (I('get.brand_id')) $condition['brand_id'] = I('get.brand_id');
        if (I('get.keyword')) $condition['search_keyword'] = I('get.keyword');
        
        $pageNum = I('get.page_num', 1);
        $perPage = I('get.per_page', 15);
        $rowCount = $youxinpaiObj->getCarCount($condition);
        if ($pageNum < 0) {
            $pageNum = ceil($rowCount/$perPage);
        }
        $carList = $youxinpaiObj->getCarListByPagination($condition, $pageNum, $perPage);
        $res = array(
            'page_num' => $pageNum,
            'row_count' => $rowCount,
            'car_list' => $carList,
        );
        $this->returnResponse($res);
    }

    /**
     * ajax获取车辆车系选项列表
     *
     * @param int $get.masterBrandID
     * 
     * @return mix
     */
    public function ajaxGetBrandOptionList() {
        $this->isLogin();
        $youxinpaiObj = D('Youxinpai', 'Service');
        $masterBrandID = I('get.master_brand_id', '');
        $res = $youxinpaiObj->getBrandOptionList($masterBrandID);
        $this->returnResponse($res);
    }

    public function taskServiceLog() {
        $this->isLogin();

        $file = C('CRAWLER_PATH_ROOT') . 'Cli' . DIRECTORY_SEPARATOR . 'Crawler' . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . 'Crawler_Youxinpai_Gettask_Worker' . DIRECTORY_SEPARATOR .'stdout.log';
        $getTask = fileTail($file, 50);

        $file = C('CRAWLER_PATH_ROOT') . 'Cli' . DIRECTORY_SEPARATOR . 'Crawler' . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . 'Crawler_Youxinpai_process_Worker' . DIRECTORY_SEPARATOR .'stdout.log';
        $processTask = fileTail($file, 50);

        $file = C('CRAWLER_PATH_ROOT') . 'Cli' . DIRECTORY_SEPARATOR . 'Crawler' . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . 'Crawler_Youxinpai_crawlerTradePrice_Worker' . DIRECTORY_SEPARATOR .'stdout.log';
        $crawlerTradePrice = fileTail($file, 50);

        // $content = file_get_contents($file);
        // $content = explode(PHP_EOL, $content);


        $this->assign('get_crawler_task', $getTask); // 通过交易大厅获取抓取任务
        $this->assign('process_task', $processTask); // 处理抓取任务
        $this->assign('crawler_trade_price', $crawlerTradePrice); // 获取交易价
        // $this->assign('content', $s);
        $this->display('task_service');
    }

    public function monitor(){
        $this->isLogin();
        if (IS_POST) {
            $frmNum = I('post.frm_num', '');
        } else {
            // 获取各任务队列待处理任务总数
            $youxinpaiObj = D('Youxinpai', 'Service');
            $auctionCount = $youxinpaiObj->getAuctionCount();
            $auctionCountHasTradePrice = $youxinpaiObj->getAuctionCountHasTradePrice();
            $dateBgn = date('Y-m-d H:i:s', strtotime('-1 day'));
            $auctionCount24 = $youxinpaiObj->getAuctionCountByTime($dateBgn);
            $auctionCountHasTradePrice24 = $youxinpaiObj->getAuctionCountHasTradePriceByTime($dateBgn);
            // 获取任务状态
            $serviceStatus = D('Youxinpai', 'Service')->crawlerTaskServiceStatus();
            $this->assign('auction_count', $auctionCount);
            $this->assign('auction_count_has_trade_price', $auctionCountHasTradePrice);
            $this->assign('auction_count_24', $auctionCount24);
            $this->assign('auction_count_has_trade_price_24', $auctionCountHasTradePrice24);
            $this->assign('service_status', $serviceStatus);
            $this->display('monitor');
        }
        return true;
    }

    public function ajaxCrawlerServiceStop() {
        $res = D('Youxinpai', 'Service')->crawlerTaskServiceStop();
        $this->returnResponse($res);
    }

    public function ajaxCrawlerServiceStart() {
        $res = D('Youxinpai', 'Service')->crawlerTaskServiceStart();
        $this->returnResponse($res);
    }

}