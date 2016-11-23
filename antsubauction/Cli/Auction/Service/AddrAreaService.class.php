<?php
namespace Auction\Service;

use Base\BaseService;

class AddrAreaService extends BaseService {
    Protected $autoCheckFields = false;


    /**
     * 获取根据城市编码获取
     * @param int $cityCode
     * @return mix
     */
    public function getCityName($cityCode = 0)
    {
        if (empty($cityCode)) {
            return false;
        }
        $modelObj = D('Auction/Aums/AddrArea', 'Model')->db(11, C('DB_AUMS'), true);
        return $modelObj->where(array('city_code' => $cityCode))->getField('city_name');
    }

}
