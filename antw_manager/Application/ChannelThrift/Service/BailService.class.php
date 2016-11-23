<?php
/**
 * 服务监控逻辑模型类
 *
 */
namespace ChannelThrift\Service;

class BailService implements \Services\BailService\BailServiceIf
{

    public function __construct()
    {
    }


    public function getDealerBail($dealerId)
    {
        $bail = new \Services\BailService\Bail();
        $bail->bailAmount = 1001;
        $bail->dealerId = $dealerId;
        $bail->freezeAmount = 1200;
        return $bail;
    }


    public function freezeBail($dealerId, $amount, $orderId){}
    public function unfreezeBail($dealerId, $amount, $orderId){}
    public function decBail($dealerId, $amount){}
    public function incBail($dealerId, $amount){}

}
