<?php

use Currency as CurrencyPrestashop;
use Jimizz\Gateway\Gateway;
use Jimizz\Gateway\Prestashop\JimizzTransaction;
use Jimizz\Gateway\TransactionType;

/**
 * Jimizz Gateway - Jimizz Payment Module for PrestaShop 1.7
 *
 * @author Jimizz Team
 * @copyright 2022 Jimizz
 */
class JimizzgatewayProcessModuleFrontController extends ModuleFrontController
{
  /** @var JimizzGateway $module */
  public $module;

  public function initContent()
  {
    $settings = $this->module->settings;

    $cart = new Cart($this->context->cart->id);
    $currency = new CurrencyPrestashop($cart->id_currency);
    $conversionRate = $currency->conversion_rate;
    $orderTotalDefaultCurrency = $cart->getOrderTotal() / $conversionRate;
    $shopName = Configuration::get('PS_SHOP_NAME');

    // Create Prestashop JimizzTransaction
    $jimizzTx = new JimizzTransaction();
    $jimizzTx->id_cart = $cart->id;
    $jimizzTx->amount = (float)$orderTotalDefaultCurrency;
    $jimizzTx->status = 'pending';
    $jimizzTx->mode = $this->module->settings->mode;
    $jimizzTx->save();

    // Create Gateway transaction
    $gateway = new Gateway($settings->merchant_id);
    $transaction = $gateway->transaction(
      $settings->mode,
      [
        'transactionId' => $jimizzTx->id,
        'amount' => $orderTotalDefaultCurrency * 100,
        'currency' => strtolower($currency->iso_code),
        'successUrl' => $this->context->link->getModuleLink(
          $this->module->name,
          'return',
          ['action' => 'success', 'tx' => $jimizzTx->id]
        ),
        'errorUrl' => $this->context->link->getModuleLink(
          $this->module->name,
          'return',
          ['action' => 'error', 'tx' => $jimizzTx->id]
        ),
        'cancelUrl' => $this->context->link->getModuleLink(
          $this->module->name,
          'return',
          ['action' => 'cancel', 'tx' => $jimizzTx->id]
        ),
        'callbackUrl' => $this->context->link->getModuleLink(
          $this->module->name,
          'callback',
          []
        ),
        'merchantName' => $shopName,
        'merchantUrl' => preg_replace('~^https?://~i', '', _PS_BASE_URL_),
      ]
    );

    // Sign transaction
    $private_key = $settings->mode === TransactionType::PRODUCTION
      ? $settings->private_key
      : $settings->test_private_key;
    $transaction->sign($private_key);

    // Display form
    $this->context->smarty->assign('form', $transaction->render('jimizz-form', false));
    $this->setTemplate('module:jimizzgateway/views/templates/front/process-form.tpl');

    parent::initContent();
  }
}
