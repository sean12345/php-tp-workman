<?php
namespace Auction\Service;

use Base\BaseService;

class CarsService extends BaseService {
    Protected $autoCheckFields = false;


    /**
     * 获取单条car数据
     * @param int $carsID
     * @return array
     */
    public function getCarsInfo($carsID = 0)
    {
        if (empty($carsID)) {
            return false;
        }
        return D('Auction/Aums/Cars')->where(array('car_id' => $carsID))->find();
    }

}
