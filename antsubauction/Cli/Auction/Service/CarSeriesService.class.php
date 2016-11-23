<?php
namespace Auction\Service;

use Base\BaseService;

class CarSeriesService extends BaseService {
    Protected $autoCheckFields = false;


    /**
     * 获取车系数据
     * @param int $carSeriesID
     * @return array
     */
    public function getCarSeriesInfo($carSeriesID = 0)
    {
        if (empty($carSeriesID)) {
            return false;
        }
        $modelObj = D('Auction/Aums/CarSeries', 'Model')->db(11, C('DB_AUMS'), true);
        return $modelObj->where(array('series_id' => $carSeriesID))->find();
    }

}
