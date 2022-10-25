<button type="button"
        class="btn btn-default dropdown-toggle"
        tabindex="-1"
        data-toggle="dropdown">
    {$language.iso_code|escape:'html':'UTF-8'}
    <i class="icon-caret-down"></i>
</button>
<ul class="dropdown-menu">
    {foreach from=$languages item=language}
        <li>
            <a href="javascript:hideOtherLanguage({$language.id_lang|intval});"
               tabindex="-1">
                {$language.name|escape:'html':'UTF-8'}
            </a>
        </li>
    {/foreach}
</ul>
