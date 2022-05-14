<?php

namespace Drupal\jugaad_products\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;

/**
 * Provides a 'JugaadProductQrCodeBlock' block.
 *
 * @Block(
 *  id = "jugaad_product_qr_code_block",
 *  admin_label = @Translation("Jugaad Product QR code block"),
 * )
 */
class JugaadProductQrCodeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
  */
  protected $routeMatch;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match')
    );
  }

  /**
   * Returns Current product page if we are on product page
   */
  protected function getNode() {
    $obj = $this->routeMatch->getParameter('node');
    if (!$obj instanceof NodeInterface) {
      throw new \UnexpectedValueException("This is not a node page");
    }

    if ($obj->bundle() !== 'jugaad_products') {
      throw new \UnexpectedValueException("This is not a product page");
    }
    return $obj;
  }  

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = $this->getNode();
    $option = [
      'query' => ['path' => $node->field_app_purchase_link->uri],
    ];
    $uri = Url::fromRoute('jugaad_products.qr', [], $option)->toString();
    $qrcodeImage = [
      '#theme' => 'image',
      '#uri' => $uri
    ];
    $build['image'] = [
      '#theme' => 'jugaad_product_qr_code_block',
      '#image' => $qrcodeImage,
    ];
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $node = $this->getNode();
    return Cache::mergeTags(parent::getCacheTags(), ['node:' . $node->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['route']);
  }

}
