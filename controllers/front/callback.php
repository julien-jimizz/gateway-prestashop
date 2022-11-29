<?php

use Jimizz\Gateway\Gateway;
use Jimizz\Gateway\Prestashop\JimizzTransaction;

/**
 * Jimizz Gateway - Jimizz Payment Module for PrestaShop 1.7
 *
 * @author Jimizz Team
 * @copyright 2022 Jimizz
 */
class JimizzgatewayCallbackModuleFrontController extends ModuleFrontController
{
  /** @var JimizzGateway $module */
  public $module;

  public function initContent()
  {
    $data = json_decode(file_get_contents('php://input'));

    try {
      $gateway = new Gateway($this->module->settings->merchant_id);
      if (!$gateway->verifyCallback($data)) {
        $this->exit500();
      } else {
        $transaction = new JimizzTransaction($data->transactionId);
        if (!empty($transaction) && property_exists($transaction, 'id_cart')) {
          if ($data->status === 'APPROVED') {
            $cart = new Cart($transaction->id_cart);
            $customer = new Customer($cart->id_customer);

            $transaction->status = 'succeed';
            $transaction->save();

            $this->module->validateOrder(
              $transaction->id_cart,
              _PS_OS_PAYMENT_,
              $transaction->amount,
              'Jimizz',
              '',
              ['transaction_id' => $transaction->tx_hash],
              null,
              false,
              $customer->secure_key
            );
          } else {
            $transaction->status = 'failed';
            $transaction->save();
          }
        }
      }

      header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK', true, 200);
      exit;
    } catch (Exception $e) {
      error_log($e);
      $this->exit500();
    }
  }

  private function exit500()
  {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    exit;
  }
}
