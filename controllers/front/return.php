<?php

use Jimizz\Gateway\Prestashop\JimizzTransaction;

/**
 * Jimizz Gateway - Jimizz Payment Module for PrestaShop 1.7
 *
 * @author Jimizz Team
 * @copyright 2022 Jimizz
 */
class JimizzgatewayReturnModuleFrontController extends ModuleFrontController
{
  public function initContent()
  {
    $action = Tools::getValue('action');
    $tx = Tools::getValue('tx');

    $jimizzTx = new JimizzTransaction($tx);
    if ($jimizzTx && !empty($jimizzTx->id_cart)) {
      if ($jimizzTx->status === 'pending') {
        $jimizzTx->status = $action === 'cancel' ? 'cancelled' : ($action === 'success' ? 'succeed' : 'failed');
        $jimizzTx->save();
      }
    }

    if ($action === 'success') {
      $this->success();
    } else {
      $this->failed();
    }
  }

  private function failed()
  {
    Tools::redirect(
      $this->context->link->getPageLink(
        'order',
        null,
        null,
        ['step' => 3]
      )
    );
  }

  private function success()
  {
    $cart = $this->context->cart;
    $customer = new Customer($cart->id_customer);

    Tools::redirect(
      $this->context->link->getPageLink(
        'order-confirmation',
        null,
        null,
        [
          'id_cart' => $cart->id,
          'id_module' => $this->module->id,
          'key' => $customer->secure_key,
        ]
      )
    );
  }
}
