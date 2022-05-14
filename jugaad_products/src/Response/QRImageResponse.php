<?php

namespace Drupal\jugaad_products\Response;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;

/**
 * Response which is returned as the QR code.
 *
 * @package Drupal\custom\Response
 */
class QRImageResponse extends Response {

  /**
   * Recourse with generated image.
   *
   * @var resource
   */
  protected $image;

  /**
   * Data to be used.
   *
   * @var data
   */
  private $data;

  /**
   * Image Size.
   *
   * @var imageSize
   */
  private $imageSize;

  /**
   * Image margin.
   *
   * @var imageMargin
   */
  private $imageMargin;

  /**
   * {@inheritdoc}
   */
  public function __construct($content, $imageSize, $imageMargin, $status = 200, $headers = []) {
    parent::__construct(NULL, $status, $headers);
    $this->data = $content;
    $this->imageSize = (NULL !== $imageSize) ? (int) $imageSize : 600;
    $this->imageMargin = (NULL !== $imageMargin) ? (int) $imageMargin : 10;
  }

  /**
   * {@inheritdoc}
   */
  public function prepare(Request $request) {
    return parent::prepare($request);
  }

  /**
   * {@inheritdoc}
   */
  public function sendHeaders() {
    $this->headers->set('content-type', 'image/jpeg');

    return parent::sendHeaders();
  }

  /**
   * {@inheritdoc}
   */
  public function sendContent() {
    $this->generateQrCode($this->data);
  }

  /**
   * Function to generate QR code for the string or URL.
   *
   * @param string $string
   *   String to be converted to Qr Code.
   */
  private function generateQrCode(string $string = '') {
    $result = Builder::create()
      ->writer(new PngWriter())
      ->writerOptions([])
      ->data($string)
      ->encoding(new Encoding('UTF-8'))
      ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
      ->size($this->imageSize)
      ->margin($this->imageMargin)
      ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
      ->build();
    if($result){
      $im = imagecreatefromstring($result->getString());
      ob_start();
      imagejpeg($im);
      imagedestroy($im);
    }
  }

}
