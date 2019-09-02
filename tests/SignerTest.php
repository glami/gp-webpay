<?php

namespace Glami\Webpay;

class SignerTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException \Glami\Webpay\SignerException
   */
  public function testConstructorWithInvalidPrivateKey() {
    $signer = new Signer(
      __DIR__ . '/keys/not-exists-key.pem',
      'changeit',
      __DIR__ . '/keys/test_cert.pem'
    );
  }

  /**
   * @expectedException \Glami\Webpay\SignerException
   */
  public function testConstructorWithInvalidPublicKey() {
    $signer = new Signer(
      __DIR__ . '/keys/test_key.pem',
      'changeit',
      __DIR__ . '/keys/not-exists-key.pem'
    );
  }

  public function testSign() {
    $privateKeyResource = openssl_pkey_get_private(
      file_get_contents(__DIR__ . '/keys/test_key.pem'),
      'changeit'
    );

    $params = array(
      'param1' => 'foo',
      'param2' => 'bar',
    );

    $digestText = implode('|', $params);
    openssl_sign($digestText, $expectedDigest, $privateKeyResource);
    $expectedDigest = base64_encode($expectedDigest);

    $signer = new Signer(
      __DIR__ . '/keys/test_key.pem',
      'changeit',
      __DIR__ . '/keys/test_cert.pem'
    );

    $this->assertEquals(
      $expectedDigest,
      $signer->sign($params)
    );
  }

  public function testVerify() {
    $privateKeyResource = openssl_pkey_get_private(
      file_get_contents(__DIR__ . '/keys/test_key.pem'),
      'changeit'
    );

    $params = array(
      'param1' => 'foo',
      'param2' => 'bar',
    );

    $digestText = implode('|', $params);
    openssl_sign($digestText, $expectedDigest, $privateKeyResource);
    $digest = base64_encode($expectedDigest);

    $signer = new Signer(
      __DIR__ . '/keys/test_key.pem',
      'changeit',
      __DIR__ . '/keys/test_cert.pem'
    );

    $signer->verify($params, $digest);
  }

  /**
   * @expectedException \Glami\Webpay\SignerException
   */
  public function testVerifyWithInvalidDigest() {
    $params = array(
      'param1' => 'foo',
      'param2' => 'bar',
    );

    $signer = new Signer(
      __DIR__ . '/keys/test_key.pem',
      'changeit',
      __DIR__ . '/keys/test_cert.pem'
    );

    $signer->verify($params, 'invalid-digest');
  }
}
