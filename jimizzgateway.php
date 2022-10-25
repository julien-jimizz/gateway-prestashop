<?php
/**
 * Jimizz Gateway - Jimizz Payment Module for PrestaShop 1.7
 *
 * @author Jimizz Team
 * @copyright 2022 Jimizz
 */

if (!defined('_PS_VERSION_')) {
  exit;
}

use Jimizz\Gateway\Prestashop\Installer;
use Jimizz\Gateway\Prestashop\Settings;
use Jimizz\Gateway\TransactionType;
use PrestaShop\PrestaShop\Core\Payment\PaymentOption;

class JimizzGateway extends PaymentModule
{
  /** @var Settings $settings */
  public $settings;

  /** @var string[] $hooks */
  public $hooks;

  /**
   * JimizzGateway constructor.
   *
   * Set the information about this module
   */
  public function __construct()
  {
    require_once(dirname(__FILE__) . '/vendor/autoload.php');

    $this->name = 'jimizzgateway';
    $this->version = '1.0.0';
    $this->author = 'Jimizz Team';
    $this->tab = 'payments_gateways';
    $this->currencies = true;
    $this->currencies_mode = 'checkbox';
    $this->bootstrap = true;
    $this->displayName = 'Jimizz Gateway';
    $this->description = 'Jimizz Payment Module.';
    $this->confirmUninstall = 'Are you sure you want to uninstall this module?';
    $this->ps_versions_compliancy = ['min' => '1.7.0', 'max' => _PS_VERSION_];
    $this->settings = new Settings();
    $this->hooks = [
      'paymentOptions',
      'paymentReturn'
    ];

    parent::__construct();
  }

  /**
   * Install this module and register the following Hooks:
   *
   * @return bool
   * @throws Exception
   */
  public function install()
  {
    try {
      if (!parent::install()) {
        return false;
      }

      $this->settings->clear();
      $this->settings = new Settings();

      $installer = new Installer($this);
      $installer->install();
    } catch (Exception $e) {
      return false;
    }

    return true;
  }

  /**
   * Uninstall this module and remove it from all hooks
   *
   * @return bool
   */
  public function uninstall()
  {
    $installer = new Installer($this);
    $installer->uninstall();

    return parent::uninstall();
  }

  /**
   * Returns a string containing the HTML necessary to
   * generate a configuration screen on the admin
   */
  public function getContent()
  {
    Tools::redirectAdmin(
      Context::getContext()
        ->link
        ->getAdminLink('AdminJimizzgatewayConfiguration')
    );
  }

  /**
   * Display this module as a payment option during the checkout
   *
   * @param array $params
   * @return array|void
   * @throws Exception
   */
  public function hookPaymentOptions($params)
  {
    // Verify if this module is active
    if (!$this->active) {
      return;
    }

    if ($this->settings->mode !== TransactionType::PRODUCTION) {
      $this->context->smarty->assign('jimizzTestMode', true);
    }

    $title = $this->settings->title[$this->context->language->iso_code] ?? $this->settings->title['en'] ?? 'Jimizz';
    $description = $this->settings->description[$this->context->language->iso_code] ?? $this->settings->description['en'] ?? 'Pay with Jimizz cryptocurrency';
    $this->context->smarty->assign('jimizzDescription', $description);

    $paymentOption = new PaymentOption();
    $paymentOption->setModuleName($this->displayName)
      ->setCallToActionText($title)
      ->setAction($this->context->link->getModuleLink($this->name, 'process'))
      ->setLogo(_MODULE_DIR_ . $this->name . '/views/img/logo-24.png')
      ->setAdditionalInformation($this->context->smarty->fetch('module:jimizzgateway/views/templates/front/additional-information.tpl'));

    return [$paymentOption];
  }

  /**
   * Display a message in the paymentReturn hook
   *
   * @param array $params
   * @return string
   */
  public function hookPaymentReturn($params)
  {
    // Verify if this module is enabled
    if (!$this->active) {
      return;
    }

    return $this->fetch('module:jimizzgateway/views/templates/hook/payment_return.tpl');
  }
}
