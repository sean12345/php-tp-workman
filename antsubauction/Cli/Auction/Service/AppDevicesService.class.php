<?php
namespace Auction\Service;

use Base\BaseService;

class AppDevicesService extends BaseService {
    Protected $autoCheckFields = false;

    /**
     * 获取设备信息
     * 
     * @param int $userID
     * @param int $userType
     * 
     * @return mix
     */
    public function getDeviceInfo($userID = 0, $userType = 0)
    {
        $res = array();
        if (empty($userID) || empty($userType)) {
            return false;
        }
        $cond = array(
            'dev_uid' => $userID,
            'dev_user_type' => $userType,
        );
        $modelObj = D('Auction/Aums/AppDevices', 'Model')->db(11, C('DB_AUMS'), true);
        $res = $modelObj->where($cond)->order('dev_modifytime desc')->find();
        return $res;
    }

}
