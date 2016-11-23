<?php
namespace Auction\Service;

use Base\BaseService;

class OrderService extends BaseService {
    Protected $autoCheckFields = false;


    /**
     * 获取单条订单数据
     * @param int $orderID
     * @return array
     */
    public function getOrderInfo($orderID = 0)
    {
        if (empty($orderID)) {
            return false;
        }
        return D('Auction/Aums/Order')->field('car_id')->where(array('order_id' => $orderID))->find();
    }

}
