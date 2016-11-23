<?php
namespace Auction\Service;

use Base\BaseService;

class CarDealerDeviceService extends BaseService {
    Protected $autoCheckFields = false;

    /**
     * 获取车商设备信息
     * @param int $userID
     * 
     * @return mix
     */
    public function getDeviceInfo($userID = 0)
    {
        if (empty($userID)) {
            return false;
        }
        $modelObj = D('Auction/Aums/CarDealerDevice', 'Model')->db(11, C('DB_AUMS'), true);
        return $modelObj->where(array('uid' => $userID))->find();
    }

}
