<div class="panel">
    <form action="#"
          method="post"
          name="jimizz_settings_form"
          id="jimizz_settings_form"
          enctype="multipart/form-data">
        <input type="hidden" name="action" value="saveSettingsForm"/>

        <div class="panel-heading">
            <i class="icon-user"></i>
            {l s='Jimizz Gateway Configuration' mod='jimizzgateway'}
        </div>

        <div class="form-group">
            <label class="control-label">
                {l s='Payment method title' mod='jimizzgateway'}
            </label>

            <div>
                {foreach from=$languages item=language}
                    <div class="translatable-field row lang-{$language.id_lang|intval}"
                         {if $language.iso_code != $lang_iso}style="display:none;"{/if}>
                        <div class="col-lg-5">
                            <input type="text"
                                   id="jimizz-title-{$language.id_lang|intval}"
                                   name="settings[title][{$language.iso_code|escape:'html':'UTF-8'}]"
                                   value="{if isset($data.title[$language.iso_code])}{$data.title[$language.iso_code|escape:'html':'UTF-8']}{/if}">
                        </div>
                        <div class="col-lg-2">{include file='./language-selector.tpl'}</div>
                    </div>
                {/foreach}
            </div>

            <div class="help-block">
                {l s='This controls the title which the user sees during checkout.' mod='jimizzgateway'}
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">
                {l s='Payment method description' mod='jimizzgateway'}
            </label>
            <div>
                {foreach from=$languages item=language}
                    <div class="translatable-field row lang-{$language.id_lang|intval}"
                         {if $language.iso_code != $lang_iso}style="display:none;"{/if}>
                        <div class="col-lg-5">
                            <textarea id="jimizz-description-{$language.id_lang|intval}"
                                      name="settings[description][{$language.iso_code|escape:'html':'UTF-8'}]"
                            >{if isset($data.description[$language.iso_code])}{$data.description[$language.iso_code]}{/if}</textarea>
                        </div>
                        <div class="col-lg-2">{include file='./language-selector.tpl'}</div>
                    </div>
                {/foreach}
            </div>

            <div class="help-block">
                {l s='Payment method description that the customer will see on your checkout.' mod='jimizzgateway'}
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">
                {l s='Mode' mod='jimizzgateway'}
            </label>
            <select name="settings[mode]">
                <option value="production"
                        {if $data.mode === 'production'}selected="selected"{/if}>
                    {l s='Production' mod='jimizzgateway'}
                </option>
                <option value="testApproved"
                        {if $data.mode === 'testApproved'}selected="selected"{/if}>
                    {l s='Test APPROVED' mod='jimizzgateway'}
                </option>
                <option value="testRejected"
                        {if $data.mode === 'testRejected'}selected="selected"{/if}>
                    {l s='Test REJECTED' mod='jimizzgateway'}
                </option>
            </select>
            <div class="help-block">
                {l s='Place the Jimizz gateway in test mode using test private key.' mod='jimizzgateway'}
            </div>
        </div>

        <div class="form-group">
            <label class="control-label">
                {l s='Merchant ID' mod='jimizzgateway'}
            </label>
            <input type="text"
                   name="settings[merchant_id]"
                   value="{$data.merchant_id|escape:'htmlall':'UTF-8'}">
        </div>

        <div class="form-group">
            <label class="control-label">
                {l s='Test Private Key' mod='jimizzgateway'}
            </label>
            <input type="password"
                   name="settings[test_private_key]"
                   autocomplete="new-password"
                   value="{$data.test_private_key|escape:'htmlall':'UTF-8'}">
        </div>

        <div class="form-group">
            <label class="control-label">
                {l s='Production Private Key' mod='jimizzgateway'}
            </label>
            <input type="password"
                   name="settings[private_key]"
                   autocomplete="new-password"
                   value="{$data.private_key|escape:'htmlall':'UTF-8'}">
        </div>

        <div class="panel-footer">
            <button type="submit" class="btn btn-default pull-right" name="submitJimizzSettingsForm">
                <i class="process-icon-save"></i> {l s='Save' mod='jimizzgateway'}
            </button>
        </div>
    </form>
</div>
