<?php

namespace Glami\GpWebpay;

class PaymentResponse {

  /** @var array */
  private $params;

  /** @var string */
  private $digest;

  /** @var string */
  private $digest1;

  /**
   * @param string $operation
   * @param string $ordernumber
   * @param string $merordernum
   * @param int $prcode
   * @param int $srcode
   * @param string $resulttext
   * @param string|null $token
   * @param string|null $tokenregstatus
   * @param string $digest
   * @param string $digest1
   * @param string $expiration
   */
  public function __construct($operation, $ordernumber, $merordernum, $prcode, $srcode, $resulttext, $token, $tokenregstatus, $digest, $digest1, $expiration) {
    $this->params['operation'] = $operation;
    $this->params['ordermumber'] = $ordernumber;
    if ($merordernum !== NULL) {
      $this->params['merordernum'] = $merordernum;
    }
    $this->params['prcode'] = (int)$prcode;
    $this->params['srcode'] = (int)$srcode;
    $this->params['resulttext'] = $resulttext;
    if ($token !== NULL) {
      $this->params['token'] = $token;
    }
    if ($expiration) {
      $this->params['expiry'] = $expiration;
    }
    if (isset($tokenregstatus)) {
      $this->params['tokenregstatus'] = $tokenregstatus;
    }

    $this->digest = $digest;
    $this->digest1 = $digest1;
  }

  public function getCardExpiration(): ?\DateTime
  {
    return !isset($this->params['expiry']) ? null : new \DateTime(substr($this->params['expiry'], 0, 2) . '-' . substr($this->params['expiry'], 2, 2) . '-01');
  }

  /**
   * @return array
   */
  public function getParams() {
    return $this->params;
  }

  /**
   * @return mixed
   */
  public function getDigest() {
    return $this->digest;
  }

  /**
   * @return bool
   */
  public function hasError() {
    return (bool)$this->params['prcode'] || (bool)$this->params['srcode'];
  }

  /**
   * @return string
   */
  public function getDigest1() {
    return $this->digest1;
  }
}
