<?php
/**
 * Jimizz Gateway - Jimizz Payment Module for PrestaShop 1.7
 *
 * @author Jimizz Team
 * @copyright 2022 Jimizz
 */

namespace Jimizz\Gateway\Prestashop;

use Configuration;
use Jimizz\Gateway\TransactionType;
use JsonSerializable;

class Settings implements JsonSerializable
{
  public const PS_CONFIG_KEY = 'JIMIZZ_GATEWAY_SETTINGS';

  private $title;
  private $description;
  private $mode;
  private $merchant_id;
  private $test_private_key;
  private $private_key;

  private $defaults = [
    'title' => 'Jimizz',
    'description' => 'Pay with Jimizz cryptocurrency',
    'mode' => TransactionType::PRODUCTION,
    'merchant_id' => '',
    'test_private_key' => '',
    'private_key' => '',
  ];

  public function __construct()
  {
    $this->_load();
  }

  public function jsonSerialize()
  {
    return [
      'title' => $this->title,
      'description' => $this->description,
      'mode' => $this->mode,
      'merchant_id' => $this->merchant_id,
      'test_private_key' => $this->test_private_key,
      'private_key' => $this->private_key
    ];
  }

  public function clear()
  {
    Configuration::updateGlobalValue(self::PS_CONFIG_KEY, '[]');
  }

  public function update($fields)
  {
    if (!$fields) {
      return;
    }

    Configuration::updateValue(self::PS_CONFIG_KEY, json_encode($fields));
  }

  private function _load()
  {
    $config = Configuration::get(self::PS_CONFIG_KEY);
    if ($config) {
      $config = array_merge($this->defaults, json_decode($config, true));
    } else {
      $config = [];
    }

    $this->title = $config['title'] ?? $this->defaults['title'];
    $this->description = $config['description'] ?? $this->defaults['description'];
    $this->mode = $config['mode'] ?? $this->defaults['mode'];
    $this->merchant_id = $config['merchant_id'] ?? $this->defaults['merchant_id'];
    $this->test_private_key = $config['test_private_key'] ?? $this->defaults['test_private_key'];
    $this->private_key = $config['private_key'] ?? $this->defaults['private_key'];
  }

  public function __get($name)
  {
    return $this->$name ?? '';
  }
}
