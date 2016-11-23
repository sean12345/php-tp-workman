<?php
namespace Auction\Service;

use Base\BaseService;

class SubscribeKeyService extends BaseService {
    Protected $autoCheckFields = false;


    /**
     * 获取订阅数据
     * @param int $orderID
     * @return array
     */
    public function getSubscribeList($keyType = 0, $keyValue = '')
    {
        if (empty($keyType) || empty($keyValue)) {
            return false;
        }
        $condition = array();
        $condition['key_type'] = $keyType;
        switch ($keyType) {
            #注册地
            case 3:
                if (!empty($keyValue[1])) {
                    $condition['key_name'] = array(array('EQ', $keyValue[0] . $keyValue[1][0]), array('EQ', -1), 'OR');
                } else {
                    $condition['key_name'] = array(array('EQ', $keyValue[0]), array('EQ', -1), 'OR');
                }
                break;
            #年限
            case 5:
                $age = diffDate($keyValue, strtotime('Y-m-d H:i:s'));
                $condition['key_name'] = array(array('EQ', $age), array('EQ', -1), 'OR');
                break;
            default:
                $condition['key_name'] = array(array('EQ', $keyValue), array('EQ', -1), 'OR');
                break;
        }
        return D('Auction/Aums/SubscribeKey')->field('key_id,key_type,uid,dealer_id,sid')->where($condition)->select();
    }


}
