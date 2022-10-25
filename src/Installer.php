<?php
/**
 * Jimizz Gateway - Jimizz Payment Module for PrestaShop 1.7
 *
 * @author Jimizz Team
 * @copyright 2022 Jimizz
 */

namespace Jimizz\Gateway\Prestashop;

use Configuration;
use Exception;
use Jimizz\Gateway\TransactionType;
use JimizzGateway;
use Language;
use PrestaShopBundle\Install\SqlLoader;
use Tab;

class Installer
{
  /** @var Jimizzgateway $module */
  public $module;

  /**
   * @param JimizzGateway $module
   */
  public function __construct($module)
  {
    $this->module = $module;
  }

  /**
   * @throws Exception
   */
  public function install()
  {
    $this->checkRequirements();
    $this->installDb();
    $this->registerHooks();
    $this->initSettings();
    $this->addTab();
  }

  public function uninstall()
  {
    Configuration::deleteByName(Settings::PS_CONFIG_KEY);
  }

  /**
   * @throws Exception
   */
  private function checkRequirements()
  {
    if (extension_loaded('curl') === false) {
      throw new Exception(
        $this->module->l('You need to enable the cURL extension to use this module.', 'Installer')
      );
    }
  }

  private function installDb()
  {
    $loader = new SqlLoader();
    $loader->setMetaData([
      '_PREFIX_' => _DB_PREFIX_,
      '_MYSQL_ENGINE_' => _MYSQL_ENGINE_
    ]);
    $loader->parseFile($this->module->getLocalPath() . 'install/install.sql');
  }

  private function registerHooks()
  {
    array_map(function ($hook) {
      $this->module->registerHook($hook);
    }, $this->module->hooks);
  }

  private function initSettings()
  {
    Configuration::updateValue(Settings::PS_CONFIG_KEY, [
      'title' => 'Jimizz',
      'description' => $this->module->l('Pay with Jimizz cryptocurrency'),
      'mode' => TransactionType::PRODUCTION,
      'merchant_id' => '',
      'test_private_key' => '',
      'private_key' => '',
    ]);
  }

  private function addTab()
  {
    $tab = new Tab();
    $tab->class_name = 'AdminJimizzgatewayConfiguration';
    $tab->module = $this->module->name;
    $tab->active = true;
    foreach (Language::getLanguages() as $lang) {
      $tab->name[$lang['id_lang']] = 'Jimizz Gateway';
    }

    if (!$tab->add()) {
      throw new Exception('Cannot add menu.');
    }
  }
}
