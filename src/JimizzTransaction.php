<?php
/**
 * Jimizz Gateway - Jimizz Payment Module for PrestaShop 1.7
 *
 * @author Jimizz Team
 * @copyright 2022 Jimizz
 */

namespace Jimizz\Gateway\Prestashop;

use ObjectModel;

class JimizzTransaction extends ObjectModel
{
  /** @var int $id_jimizz_transaction */
  public $id_jimizz_transaction;

  /** @var int $id_cart */
  public $id_cart;

  /** @var int $amount */
  public $amount;

  /** @var string $mode */
  public $mode;

  /** @var string $status */
  public $status;

  /** @var string $tx_hash */
  public $tx_hash;

  public static $definition = [
    'table' => 'jimizz_transaction',
    'primary' => 'id_jimizz_transaction',
    'fields' => [
      'id_cart' => ['type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedInt'],
      'amount' => ['type' => self::TYPE_FLOAT, 'required' => true],
      'mode' => ['type' => self::TYPE_STRING, 'required' => true],
      'status' => ['type' => self::TYPE_STRING, 'required' => true],
    ]
  ];
}
