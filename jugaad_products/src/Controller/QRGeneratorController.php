<?php

namespace Drupal\jugaad_products\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\jugaad_products\Response\QRImageResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Controller which generates the QR Code image from defined settings.
 */
class QRGeneratorController extends ControllerBase {

  /**
   * Request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $request;

  /**
   * QRGeneratorController constructor.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $request
   *   Request object to get request params.
   */
  public function __construct(RequestStack $request) {
    $this->request = $request;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack')
    );
  }

  /**
   * LogoSize.
   *
   * @return int
   *   Will return the logo size.
   */
  public function getLogoSize() {
    return $this->config('jugaad_products.settings')->get('image_size');
  }

  /**
   * LogoMargin.
   *
   * @return int
   *   Will return the logo margin.
   */
  public function getLogoMargin() {
    return $this->config('jugaad_products.settings')->get('image_margin');
  }

  /**
   * Will return the response for external url.
   *
   * @return \Drupal\jugaad_products\Response\QRImageRespons
   *   Will return the image response.
   */
  public function imageUrl() {
    $externalUrl = $this->request->getCurrentRequest()->query->get('path');
    return new QRImageResponse($externalUrl, $this->getLogoSize(), $this->getLogoMargin());
  }

}
