<?php

namespace ChannelThrift\Controller;

require_once MODULE_PATH . 'Org/Thrift/ClassLoader/ThriftClassLoader.php';

use Services\BailService\BailServiceClient;
use Thrift\ClassLoader\ThriftClassLoader;

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', MODULE_PATH . 'Org/Thrift/Lib');
$loader->registerDefinition('Services', MODULE_PATH . 'Org/Thrift/gen-php');
$loader->register();

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Protocol\TMultiplexedProtocol;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;

class ClientController extends CommonController
{

    public function runBail()
    {
        try {
            $handle = new THttpClient('wangrongfu.manager.antnest.clcw.com.cn', 80, '/ChannelThrift/Server/runBail');
//            $handle = new TSocket('localhost', 9090);
            $transport = new TBufferedTransport($handle);
            $protocol = new TBinaryProtocol($transport);
            $bailProtocol = new TMultiplexedProtocol($protocol, 'BailService');
            $bailService = new BailServiceClient($bailProtocol);

            $dealer = $bailService->getDealerBail(5);
            var_dump($dealer);

        } catch (TException $tx) {
            print 'TException: ' . $tx->getMessage() . "\n";
        }
    }


}
