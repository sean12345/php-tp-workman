<?php

namespace ChannelThrift\Controller;

require_once MODULE_PATH .'Org/Thrift/ClassLoader/ThriftClassLoader.php';

use ChannelThrift\Service\BailService;
use Services\BailService\BailServiceProcessor;
use Thrift\ClassLoader\ThriftClassLoader;

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', MODULE_PATH . 'Org/Thrift/Lib');
$loader->registerDefinition('Services', MODULE_PATH . 'Org/Thrift/gen-php');
$loader->register();

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TPhpStream;
use Thrift\Transport\TBufferedTransport;
use Thrift\TMultiplexedProcessor;

class ServerController extends CommonController
{
    public function _initialize()
    {
        header('Content-Type', 'application/x-thrift');
    }


    public function runBail()
    {
        $transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
        $protocol = new TBinaryProtocol($transport, true, true);
        $tMultiplexedProcessor = new TMultiplexedProcessor();

        $handler = new BailService();
        $bailServiceProcessor = new BailServiceProcessor($handler);
        $tMultiplexedProcessor->registerProcessor("BailService", $bailServiceProcessor);

        $transport->open();
        $tMultiplexedProcessor->process($protocol, $protocol);
        $transport->close();
        
    }

}