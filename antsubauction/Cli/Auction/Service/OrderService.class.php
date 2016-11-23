<?php
namespace Auction\Service;

use Base\ExceptionHandler;
use Base\BaseService;
use \Common\Org\PhpRedis;

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
        // $res = D('Auction/Aums/Order', 'Model')->db(1, C('DB_AUMS'), true)->where(array('order_id' => $orderID))->find();
        $orderModel = D('Auction/Aums/Order', 'Model')->db(11, C('DB_AUMS'), true);
        $res = $orderModel->where(array('order_id' => $orderID))->find();
        return $res;
    }

}
