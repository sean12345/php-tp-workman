<?php
namespace Services\AuctionService;
/**
 * Autogenerated by Thrift Compiler (0.9.3)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


interface AuctionServiceIf {
  /**
   * @param int $dealerId
   * @param int $orderId
   * @param double $price
   * @return bool
   * @throws \Services\AuctionService\InvalidException
   */
  public function bidding($dealerId, $orderId, $price);
  /**
   * @param int $dealerId
   * @param int $orderId
   * @param double $price
   * @return bool
   * @throws \Services\AuctionService\InvalidException
   */
  public function bid($dealerId, $orderId, $price);
  /**
   * @param \Services\AuctionService\Scene $scenne
   * @return bool
   * @throws \Services\AuctionService\InvalidException
   */
  public function startAuction(\Services\AuctionService\Scene $scenne);
}

class AuctionServiceClient implements \Services\AuctionService\AuctionServiceIf {
  protected $input_ = null;
  protected $output_ = null;

  protected $seqid_ = 0;

  public function __construct($input, $output=null) {
    $this->input_ = $input;
    $this->output_ = $output ? $output : $input;
  }

  public function bidding($dealerId, $orderId, $price)
  {
    $this->send_bidding($dealerId, $orderId, $price);
    return $this->recv_bidding();
  }

  public function send_bidding($dealerId, $orderId, $price)
  {
    $args = new \Services\AuctionService\AuctionService_bidding_args();
    $args->dealerId = $dealerId;
    $args->orderId = $orderId;
    $args->price = $price;
    $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'bidding', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('bidding', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_bidding()
  {
    $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Services\AuctionService\AuctionService_bidding_result', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Services\AuctionService\AuctionService_bidding_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    if ($result->ex !== null) {
      throw $result->ex;
    }
    throw new \Exception("bidding failed: unknown result");
  }

  public function bid($dealerId, $orderId, $price)
  {
    $this->send_bid($dealerId, $orderId, $price);
    return $this->recv_bid();
  }

  public function send_bid($dealerId, $orderId, $price)
  {
    $args = new \Services\AuctionService\AuctionService_bid_args();
    $args->dealerId = $dealerId;
    $args->orderId = $orderId;
    $args->price = $price;
    $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'bid', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('bid', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_bid()
  {
    $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Services\AuctionService\AuctionService_bid_result', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Services\AuctionService\AuctionService_bid_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    if ($result->ex !== null) {
      throw $result->ex;
    }
    throw new \Exception("bid failed: unknown result");
  }

  public function startAuction(\Services\AuctionService\Scene $scenne)
  {
    $this->send_startAuction($scenne);
    return $this->recv_startAuction();
  }

  public function send_startAuction(\Services\AuctionService\Scene $scenne)
  {
    $args = new \Services\AuctionService\AuctionService_startAuction_args();
    $args->scenne = $scenne;
    $bin_accel = ($this->output_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($this->output_, 'startAuction', TMessageType::CALL, $args, $this->seqid_, $this->output_->isStrictWrite());
    }
    else
    {
      $this->output_->writeMessageBegin('startAuction', TMessageType::CALL, $this->seqid_);
      $args->write($this->output_);
      $this->output_->writeMessageEnd();
      $this->output_->getTransport()->flush();
    }
  }

  public function recv_startAuction()
  {
    $bin_accel = ($this->input_ instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_read_binary');
    if ($bin_accel) $result = thrift_protocol_read_binary($this->input_, '\Services\AuctionService\AuctionService_startAuction_result', $this->input_->isStrictRead());
    else
    {
      $rseqid = 0;
      $fname = null;
      $mtype = 0;

      $this->input_->readMessageBegin($fname, $mtype, $rseqid);
      if ($mtype == TMessageType::EXCEPTION) {
        $x = new TApplicationException();
        $x->read($this->input_);
        $this->input_->readMessageEnd();
        throw $x;
      }
      $result = new \Services\AuctionService\AuctionService_startAuction_result();
      $result->read($this->input_);
      $this->input_->readMessageEnd();
    }
    if ($result->success !== null) {
      return $result->success;
    }
    if ($result->ex !== null) {
      throw $result->ex;
    }
    throw new \Exception("startAuction failed: unknown result");
  }

}

// HELPER FUNCTIONS AND STRUCTURES

class AuctionService_bidding_args {
  static $_TSPEC;

  /**
   * @var int
   */
  public $dealerId = null;
  /**
   * @var int
   */
  public $orderId = null;
  /**
   * @var double
   */
  public $price = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'dealerId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'orderId',
          'type' => TType::I64,
          ),
        3 => array(
          'var' => 'price',
          'type' => TType::DOUBLE,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['dealerId'])) {
        $this->dealerId = $vals['dealerId'];
      }
      if (isset($vals['orderId'])) {
        $this->orderId = $vals['orderId'];
      }
      if (isset($vals['price'])) {
        $this->price = $vals['price'];
      }
    }
  }

  public function getName() {
    return 'AuctionService_bidding_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->dealerId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->orderId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::DOUBLE) {
            $xfer += $input->readDouble($this->price);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('AuctionService_bidding_args');
    if ($this->dealerId !== null) {
      $xfer += $output->writeFieldBegin('dealerId', TType::I64, 1);
      $xfer += $output->writeI64($this->dealerId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->orderId !== null) {
      $xfer += $output->writeFieldBegin('orderId', TType::I64, 2);
      $xfer += $output->writeI64($this->orderId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->price !== null) {
      $xfer += $output->writeFieldBegin('price', TType::DOUBLE, 3);
      $xfer += $output->writeDouble($this->price);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class AuctionService_bidding_result {
  static $_TSPEC;

  /**
   * @var bool
   */
  public $success = null;
  /**
   * @var \Services\AuctionService\InvalidException
   */
  public $ex = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::BOOL,
          ),
        1 => array(
          'var' => 'ex',
          'type' => TType::STRUCT,
          'class' => '\Services\AuctionService\InvalidException',
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['success'])) {
        $this->success = $vals['success'];
      }
      if (isset($vals['ex'])) {
        $this->ex = $vals['ex'];
      }
    }
  }

  public function getName() {
    return 'AuctionService_bidding_result';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 0:
          if ($ftype == TType::BOOL) {
            $xfer += $input->readBool($this->success);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 1:
          if ($ftype == TType::STRUCT) {
            $this->ex = new \Services\AuctionService\InvalidException();
            $xfer += $this->ex->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('AuctionService_bidding_result');
    if ($this->success !== null) {
      $xfer += $output->writeFieldBegin('success', TType::BOOL, 0);
      $xfer += $output->writeBool($this->success);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->ex !== null) {
      $xfer += $output->writeFieldBegin('ex', TType::STRUCT, 1);
      $xfer += $this->ex->write($output);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class AuctionService_bid_args {
  static $_TSPEC;

  /**
   * @var int
   */
  public $dealerId = null;
  /**
   * @var int
   */
  public $orderId = null;
  /**
   * @var double
   */
  public $price = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'dealerId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'orderId',
          'type' => TType::I64,
          ),
        3 => array(
          'var' => 'price',
          'type' => TType::DOUBLE,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['dealerId'])) {
        $this->dealerId = $vals['dealerId'];
      }
      if (isset($vals['orderId'])) {
        $this->orderId = $vals['orderId'];
      }
      if (isset($vals['price'])) {
        $this->price = $vals['price'];
      }
    }
  }

  public function getName() {
    return 'AuctionService_bid_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->dealerId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->orderId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::DOUBLE) {
            $xfer += $input->readDouble($this->price);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('AuctionService_bid_args');
    if ($this->dealerId !== null) {
      $xfer += $output->writeFieldBegin('dealerId', TType::I64, 1);
      $xfer += $output->writeI64($this->dealerId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->orderId !== null) {
      $xfer += $output->writeFieldBegin('orderId', TType::I64, 2);
      $xfer += $output->writeI64($this->orderId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->price !== null) {
      $xfer += $output->writeFieldBegin('price', TType::DOUBLE, 3);
      $xfer += $output->writeDouble($this->price);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class AuctionService_bid_result {
  static $_TSPEC;

  /**
   * @var bool
   */
  public $success = null;
  /**
   * @var \Services\AuctionService\InvalidException
   */
  public $ex = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::BOOL,
          ),
        1 => array(
          'var' => 'ex',
          'type' => TType::STRUCT,
          'class' => '\Services\AuctionService\InvalidException',
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['success'])) {
        $this->success = $vals['success'];
      }
      if (isset($vals['ex'])) {
        $this->ex = $vals['ex'];
      }
    }
  }

  public function getName() {
    return 'AuctionService_bid_result';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 0:
          if ($ftype == TType::BOOL) {
            $xfer += $input->readBool($this->success);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 1:
          if ($ftype == TType::STRUCT) {
            $this->ex = new \Services\AuctionService\InvalidException();
            $xfer += $this->ex->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('AuctionService_bid_result');
    if ($this->success !== null) {
      $xfer += $output->writeFieldBegin('success', TType::BOOL, 0);
      $xfer += $output->writeBool($this->success);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->ex !== null) {
      $xfer += $output->writeFieldBegin('ex', TType::STRUCT, 1);
      $xfer += $this->ex->write($output);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class AuctionService_startAuction_args {
  static $_TSPEC;

  /**
   * @var \Services\AuctionService\Scene
   */
  public $scenne = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'scenne',
          'type' => TType::STRUCT,
          'class' => '\Services\AuctionService\Scene',
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['scenne'])) {
        $this->scenne = $vals['scenne'];
      }
    }
  }

  public function getName() {
    return 'AuctionService_startAuction_args';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::STRUCT) {
            $this->scenne = new \Services\AuctionService\Scene();
            $xfer += $this->scenne->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('AuctionService_startAuction_args');
    if ($this->scenne !== null) {
      if (!is_object($this->scenne)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('scenne', TType::STRUCT, 1);
      $xfer += $this->scenne->write($output);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class AuctionService_startAuction_result {
  static $_TSPEC;

  /**
   * @var bool
   */
  public $success = null;
  /**
   * @var \Services\AuctionService\InvalidException
   */
  public $ex = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::BOOL,
          ),
        1 => array(
          'var' => 'ex',
          'type' => TType::STRUCT,
          'class' => '\Services\AuctionService\InvalidException',
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['success'])) {
        $this->success = $vals['success'];
      }
      if (isset($vals['ex'])) {
        $this->ex = $vals['ex'];
      }
    }
  }

  public function getName() {
    return 'AuctionService_startAuction_result';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 0:
          if ($ftype == TType::BOOL) {
            $xfer += $input->readBool($this->success);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 1:
          if ($ftype == TType::STRUCT) {
            $this->ex = new \Services\AuctionService\InvalidException();
            $xfer += $this->ex->read($input);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('AuctionService_startAuction_result');
    if ($this->success !== null) {
      $xfer += $output->writeFieldBegin('success', TType::BOOL, 0);
      $xfer += $output->writeBool($this->success);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->ex !== null) {
      $xfer += $output->writeFieldBegin('ex', TType::STRUCT, 1);
      $xfer += $this->ex->write($output);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class AuctionServiceProcessor {
  protected $handler_ = null;
  public function __construct($handler) {
    $this->handler_ = $handler;
  }

  public function process($input, $output) {
    $rseqid = 0;
    $fname = null;
    $mtype = 0;

    $input->readMessageBegin($fname, $mtype, $rseqid);
    $methodname = 'process_'.$fname;
    if (!method_exists($this, $methodname)) {
      $input->skip(TType::STRUCT);
      $input->readMessageEnd();
      $x = new TApplicationException('Function '.$fname.' not implemented.', TApplicationException::UNKNOWN_METHOD);
      $output->writeMessageBegin($fname, TMessageType::EXCEPTION, $rseqid);
      $x->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
      return;
    }
    $this->$methodname($rseqid, $input, $output);
    return true;
  }

  protected function process_bidding($seqid, $input, $output) {
    $args = new \Services\AuctionService\AuctionService_bidding_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Services\AuctionService\AuctionService_bidding_result();
    try {
      $result->success = $this->handler_->bidding($args->dealerId, $args->orderId, $args->price);
    } catch (\Services\AuctionService\InvalidException $ex) {
      $result->ex = $ex;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'bidding', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('bidding', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_bid($seqid, $input, $output) {
    $args = new \Services\AuctionService\AuctionService_bid_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Services\AuctionService\AuctionService_bid_result();
    try {
      $result->success = $this->handler_->bid($args->dealerId, $args->orderId, $args->price);
    } catch (\Services\AuctionService\InvalidException $ex) {
      $result->ex = $ex;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'bid', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('bid', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
  protected function process_startAuction($seqid, $input, $output) {
    $args = new \Services\AuctionService\AuctionService_startAuction_args();
    $args->read($input);
    $input->readMessageEnd();
    $result = new \Services\AuctionService\AuctionService_startAuction_result();
    try {
      $result->success = $this->handler_->startAuction($args->scenne);
    } catch (\Services\AuctionService\InvalidException $ex) {
      $result->ex = $ex;
    }
    $bin_accel = ($output instanceof TBinaryProtocolAccelerated) && function_exists('thrift_protocol_write_binary');
    if ($bin_accel)
    {
      thrift_protocol_write_binary($output, 'startAuction', TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
    }
    else
    {
      $output->writeMessageBegin('startAuction', TMessageType::REPLY, $seqid);
      $result->write($output);
      $output->writeMessageEnd();
      $output->getTransport()->flush();
    }
  }
}
