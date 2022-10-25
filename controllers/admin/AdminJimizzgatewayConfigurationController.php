<?php
/**
 * Jimizz Gateway - Jimizz Payment Module for PrestaShop 1.7
 *
 * @author Jimizz Team
 * @copyright 2022 Jimizz
 */

use Jimizz\Gateway\Prestashop\Settings;

class AdminJimizzgatewayConfigurationController extends ModuleAdminController
{
  /** @var JimizzGateway $module */
  public $module;

  public function __construct()
  {
    $this->bootstrap = true;
    parent::__construct();
  }

  public function initContent()
  {
    $this->context->smarty->assign([
      'data' => json_decode(json_encode($this->module->settings), true),
      'languages' => $this->getLanguages(),
    ]);
    $this->content = $this->createTemplate('layout.tpl')->fetch();

    parent::initContent();
  }

  public function postProcess()
  {
    $postProcess = parent::postProcess();
    $this->module->settings = new Settings();

    return $postProcess;
  }

  public function processSaveSettingsForm()
  {
    $this->module->settings->update(Tools::getValue('settings'));
    $this->confirmations[] = $this->module->l('Settings saved successfully', 'AdminJimizzgatewayConfigurationController');
  }
}
