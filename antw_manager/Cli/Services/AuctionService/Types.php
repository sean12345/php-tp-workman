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


class InvalidException extends TException {
  static $_TSPEC;

  /**
   * @var int
   */
  public $code = null;
  /**
   * @var string
   */
  public $message = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'code',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'message',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['code'])) {
        $this->code = $vals['code'];
      }
      if (isset($vals['message'])) {
        $this->message = $vals['message'];
      }
    }
  }

  public function getName() {
    return 'InvalidException';
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
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->code);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->message);
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
    $xfer += $output->writeStructBegin('InvalidException');
    if ($this->code !== null) {
      $xfer += $output->writeFieldBegin('code', TType::I32, 1);
      $xfer += $output->writeI32($this->code);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->message !== null) {
      $xfer += $output->writeFieldBegin('message', TType::STRING, 2);
      $xfer += $output->writeString($this->message);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class Scene {
  static $_TSPEC;

  /**
   * @var int
   */
  public $orderId = null;
  /**
   * @var int
   */
  public $sceneId = null;
  /**
   * @var string
   */
  public $biddingStartTime = null;
  /**
   * @var string
   */
  public $biddingEndTime = null;
  /**
   * @var int
   */
  public $estElapsedTime = null;
  /**
   * @var int
   */
  public $actElapsedTime = null;
  /**
   * @var bool
   */
  public $isTimingOrder = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'orderId',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'sceneId',
          'type' => TType::I64,
          ),
        3 => array(
          'var' => 'biddingStartTime',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'biddingEndTime',
          'type' => TType::STRING,
          ),
        5 => array(
          'var' => 'estElapsedTime',
          'type' => TType::I64,
          ),
        6 => array(
          'var' => 'actElapsedTime',
          'type' => TType::I64,
          ),
        7 => array(
          'var' => 'isTimingOrder',
          'type' => TType::BOOL,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['orderId'])) {
        $this->orderId = $vals['orderId'];
      }
      if (isset($vals['sceneId'])) {
        $this->sceneId = $vals['sceneId'];
      }
      if (isset($vals['biddingStartTime'])) {
        $this->biddingStartTime = $vals['biddingStartTime'];
      }
      if (isset($vals['biddingEndTime'])) {
        $this->biddingEndTime = $vals['biddingEndTime'];
      }
      if (isset($vals['estElapsedTime'])) {
        $this->estElapsedTime = $vals['estElapsedTime'];
      }
      if (isset($vals['actElapsedTime'])) {
        $this->actElapsedTime = $vals['actElapsedTime'];
      }
      if (isset($vals['isTimingOrder'])) {
        $this->isTimingOrder = $vals['isTimingOrder'];
      }
    }
  }

  public function getName() {
    return 'Scene';
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
            $xfer += $input->readI64($this->orderId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->sceneId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->biddingStartTime);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->biddingEndTime);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 5:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->estElapsedTime);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 6:
          if ($ftype == TType::I64) {
            $xfer += $input->readI64($this->actElapsedTime);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 7:
          if ($ftype == TType::BOOL) {
            $xfer += $input->readBool($this->isTimingOrder);
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
    $xfer += $output->writeStructBegin('Scene');
    if ($this->orderId !== null) {
      $xfer += $output->writeFieldBegin('orderId', TType::I64, 1);
      $xfer += $output->writeI64($this->orderId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->sceneId !== null) {
      $xfer += $output->writeFieldBegin('sceneId', TType::I64, 2);
      $xfer += $output->writeI64($this->sceneId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->biddingStartTime !== null) {
      $xfer += $output->writeFieldBegin('biddingStartTime', TType::STRING, 3);
      $xfer += $output->writeString($this->biddingStartTime);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->biddingEndTime !== null) {
      $xfer += $output->writeFieldBegin('biddingEndTime', TType::STRING, 4);
      $xfer += $output->writeString($this->biddingEndTime);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->estElapsedTime !== null) {
      $xfer += $output->writeFieldBegin('estElapsedTime', TType::I64, 5);
      $xfer += $output->writeI64($this->estElapsedTime);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->actElapsedTime !== null) {
      $xfer += $output->writeFieldBegin('actElapsedTime', TType::I64, 6);
      $xfer += $output->writeI64($this->actElapsedTime);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->isTimingOrder !== null) {
      $xfer += $output->writeFieldBegin('isTimingOrder', TType::BOOL, 7);
      $xfer += $output->writeBool($this->isTimingOrder);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}


