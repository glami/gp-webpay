<?php

namespace Glami\GpWebpay\Tests;

use Glami\GpWebpay\PaymentResponse;

class PaymentResponseTest extends \PHPUnit_Framework_TestCase {

  public function errorCodesProvider() {
    return [
      [
        [
          'prcode' => 0,
          'srcode' => 0,
        ],
        false
      ],
      [
        [
          'prcode' => 97,
          'srcode' => 0,
        ],
        true
      ],
      [
        [
          'prcode' => 12,
          'srcode' => 32,
        ],
        true
      ],
    ];
  }

  /**
   * @dataProvider errorCodesProvider
   */
  public function testHasError($codes, $result) {
    $response = new PaymentResponse(
      'operation',
      'ordernumber',
      'merordernum',
      $codes['prcode'],
      $codes['srcode'],
      'resultext',
      null,
      'digest',
      'digest1'
    );

    $this->assertEquals($result, $response->hasError());
  }
}
