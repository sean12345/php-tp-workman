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
        $modelObj = D('Auction/Aums/Cars', 'Model')->db(11, C('DB_AUMS'), true);
        return $modelObj->where(array('car_id' => $carsID))->find();
    }


    /**
     * 获取车辆标题
     * 
     * @param  int  $carID
     * 
     * @return mix
     */
    public function getCarTitle($carID = '') {
        $res = '';
        $carInfo = $this->getCarsInfo($carID);
        $seriesInfo = D('Auction/CarSeries', 'Service')->getCarSeriesInfo($carInfo['series_id']);
        $cityName = D('Auction/AddrArea', 'Service')->getCityName($carInfo['location_area']);
        if ($carInfo && $seriesInfo) {
            $res = '[' . $cityName . ']' . $seriesInfo['name'] . ' ' . $carInfo['car_cc'] . ($carInfo['turbo'] ? 'T' : 'L') . ' ' . C('GEARBOX.' . $carInfo['gearbox']);
        }
        return $res;
    }

}
