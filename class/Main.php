<?php

namespace Nikolays93\Fancybox;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Page\Asset;

class Main
{
    public function appendAssets()
    {
    	$module_id = 'nikolays93.fancybox';

    	// No admin panel script.
    	$isAdmin = defined('ADMIN_SECTION') && ADMIN_SECTION;
    	if( $isAdmin ) return;

    	// Script disabled.
    	if( 'Y' !== Option::get($module_id, 'enable', 'Y') ) return;

    	$jsParams = array(
    		'selector' => Option::get($module_id, 'selector', 'Y'),
    	);

        Asset::getInstance()->addString("
            <script>
            	var fancyboxModule = new FancyboxModule(<?= CUtil::PhpToJSObject($jsParams, false, true) ?>);
            </script>",
            true
        );

        Asset::getInstance()->addJs('/bitrix/js/'.$module_id.'/script.js');
    }
}
