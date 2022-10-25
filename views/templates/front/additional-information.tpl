{if isset($jimizzTestMode)}
    <div class="alert alert-warning">
        <span>{l s='You are using Jimizz Gateway test environment' mod='jimizzgateway'}</span>
    </div>
{/if}
{if isset($jimizzDescription)}
    <p>{$jimizzDescription}</p>
{/if}
