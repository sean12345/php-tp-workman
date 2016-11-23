<?php
namespace Auction\Service;

use Base\BaseService;

class SubscribeOrderService extends BaseService {
    Protected $autoCheckFields = false;


    /**
     * 批量添加数据
     * @param array $data
     * @return array
     */
    public function addSubscribeOrder($data = array())
    {
        if (empty($data) ) {
            return false;
        }
        $modelObj = D('Auction/Aums/SubscribeOrder', 'Model')->db(11, C('DB_AUMS'), true);
        return $modelObj->addAll($data);
    }


}
